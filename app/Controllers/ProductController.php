<?php

namespace Vovanmix\CustomAdmin\Controllers;

use Vovanmix\CustomAdmin\Lib\Mvc\Controller;
use Vovanmix\CustomAdmin\Lib\Mvc\ModelInterface;
use Vovanmix\CustomAdmin\Repositories\ProductRepository;
use Vovanmix\CustomAdmin\Repositories\CategoryRepository;
use Vovanmix\CustomAdmin\Repositories\ProductImageRepository;
use Vovanmix\CustomAdmin\Models\Product;
use Vovanmix\CustomAdmin\Models\ProductImage;
use Vovanmix\CustomAdmin\Lib\Http\Request;
use Vovanmix\CustomAdmin\Lib\Exceptions\ValidationException;

class ProductController extends Controller{

    /**
     * @param ProductRepository $ProductRepository
     * @return string
     */
    public function index(ProductRepository $ProductRepository){
        $products = $ProductRepository->findAll();
        return $this->render('index', ['products' => $products]);
    }

    /**
     * @param int $id
     * @param ProductRepository $ProductRepository
     */
    public function delete($id, ProductRepository $ProductRepository){
        $product = $ProductRepository->getById($id);
        $product->delete();

        $this->setFlash('Product was successfully deleted');
        redirect('/product');
    }

    /**
     * @param CategoryRepository $CategoryRepository
     * @param Request $Request
     * @return string
     */
    public function add(CategoryRepository $CategoryRepository, Request $Request){
        $product = $this->createModelInstance("Product");

        return $this->processInput($product, $CategoryRepository, 'persistAdd', $Request);
    }

    /**
     * @param int $id
     * @param ProductRepository $ProductRepository
     * @param CategoryRepository $CategoryRepository
     * @param Request $Request
     * @return string
     */
    public function edit($id, ProductRepository $ProductRepository, CategoryRepository $CategoryRepository, Request $Request){
        $product = $ProductRepository->getById($id);

        return $this->processInput($product, $CategoryRepository, 'persistEdit', $Request);
    }

    /**
     * @param ModelInterface|Product $product
     * @param CategoryRepository $CategoryRepository
     * @param string $persistMethod
     * @param Request $Request
     * @return string
     */
    private function processInput($product, $CategoryRepository, $persistMethod, $Request){
        $post = $Request->inputPostAll();
        if(empty($post)){
            return $this->input($product, $CategoryRepository);
        }
        else{
            return $this->$persistMethod($product, $CategoryRepository, $Request);
        }
    }

    /**
     * @param ModelInterface|Product $product
     * @param CategoryRepository $CategoryRepository
     * @return string
     */
    protected function input($product, $CategoryRepository){
        $categories = $CategoryRepository->findAll();
        return $this->render('input', ['product' => $product, 'categories' => $categories]);
    }

    /**
     * @param Product $product
     * @param CategoryRepository $CategoryRepository
     * @param Request $Request
     * @return null|string
     */
    protected function persistAdd($product, $CategoryRepository, $Request){
        $post = $Request->inputPostAll();
        try {
            $product->fillData($post);
            $product->save();
            $this->processNewImages($product, $Request);
        }
        catch(ValidationException $e){
            $this->setFlash($e->getMessage());
            return $this->input($product, $CategoryRepository);
        }

        $this->setFlash('Product was successfully added');
        redirect('/product');
        return null;
    }

    /**
     * @param Product $product
     * @param CategoryRepository $CategoryRepository
     * @param Request $Request
     * @return null|string
     */
    protected function persistEdit($product, $CategoryRepository, $Request){
        $post = $Request->inputPostAll();
        try {
            $product->fillData($post);
            $product->update();
            $this->processNewImages($product, $Request);
            $this->processRemoveImages($product, $Request);
        }
        catch(ValidationException $e){
            $this->setFlash($e->getMessage());
            return $this->input($product, $CategoryRepository);
        }

        $this->setFlash('Product was successfully updated');
        redirect('/product');
        return null;
    }

    /**
     * @param Product $product
     * @param Request $Request
     */
    protected function processNewImages($product, $Request){
        $newImages = $Request->inputFile('newImages');

        if(!empty($newImages)) {
            if (isset($newImages['name'])) {
                $newImages = [$newImages];
            }
            foreach ($newImages as $newImage) {
                if (!empty($newImage['tmp_name'])) {
                    /** @var ProductImage $ProductImage */
                    $ProductImage = $this->createModelInstance('ProductImage');
                    $ProductImage->setProduct($product);
                    $ProductImage->generateName($newImage);

                    copy($newImage['tmp_name'], WEBROOT . '/uploads/' . $ProductImage->getFile());

                    $ProductImage->save();
                }
            }
        }
    }

    /**
     * @param Product $product
     * @param Request $Request
     */
    protected function processRemoveImages($product, $Request){
        $imagesDelete = $Request->inputPost('imagesDelete');

        if(!empty($imagesDelete)) {
            foreach ($imagesDelete as $imageId => $value) {
                if (!empty($value)) {
                    /** @var ProductImage $ProductImage */
                    $ProductImage = $this->getDependencyInjector()->getClassInstance("\\Vovanmix\\CustomAdmin\\Repositories\\ProductImageRepository")->getById($imageId);
                    if ($ProductImage->getProduct_id() == $product->getId()) {
                        unlink(WEBROOT . '/uploads/' . $ProductImage->getFile());
                        $ProductImage->delete();
                    }
                }
            }
        }
    }
}
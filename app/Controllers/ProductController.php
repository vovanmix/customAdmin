<?php

namespace Vovanmix\CustomAdmin\Controllers;

use Vovanmix\CustomAdmin\Lib\Mvc\Controller;
use Vovanmix\CustomAdmin\Lib\Mvc\ModelInterface;
use Vovanmix\CustomAdmin\Repositories\ProductRepository;
use Vovanmix\CustomAdmin\Repositories\CategoryRepository;
use \Vovanmix\CustomAdmin\Models\Product;

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
     * @return string
     */
    public function add(CategoryRepository $CategoryRepository){
        $product = $this->createModelInstance("Product");

        return $this->processInput($product, $CategoryRepository, 'persistAdd');
    }

    /**
     * @param int $id
     * @param ProductRepository $ProductRepository
     * @param CategoryRepository $CategoryRepository
     * @return string
     */
    public function edit($id, ProductRepository $ProductRepository, CategoryRepository $CategoryRepository){
        $product = $ProductRepository->getById($id);

        return $this->processInput($product, $CategoryRepository, 'persistEdit');
    }

    /**
     * @param ModelInterface|Product $product
     * @param CategoryRepository $CategoryRepository
     * @param string $persistMethod
     * @return string
     */
    private function processInput($product, $CategoryRepository, $persistMethod){
        $post = $this->getContainer()->getRequest()->inputPostAll();
        if(empty($post)){
            return $this->input($product, $CategoryRepository);
        }
        else{
            return $this->$persistMethod($product);
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
     * @return string
     */
    protected function persistAdd($product){
        $post = $this->getContainer()->getRequest()->inputPostAll();
        $product->fillData($post);
        $product->save();

        $this->setFlash('Product was successfully added');
        redirect('/product');
    }

    /**
     * @param Product $product
     * @return string
     */
    protected function persistEdit($product){
        $post = $this->getContainer()->getRequest()->inputPostAll();
        $product->fillData($post);
        $product->update();

        $this->setFlash('Product was successfully updated');
        redirect('/product');
    }
}
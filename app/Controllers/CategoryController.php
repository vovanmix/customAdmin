<?php

namespace Vovanmix\CustomAdmin\Controllers;

use Vovanmix\CustomAdmin\Lib\Mvc\Controller;
use Vovanmix\CustomAdmin\Lib\Mvc\ModelInterface;
use Vovanmix\CustomAdmin\Repositories\CategoryRepository;
use \Vovanmix\CustomAdmin\Models\Category;
use Vovanmix\CustomAdmin\Lib\Exceptions\ValidationException;

class CategoryController extends Controller{

    /**
     * @param CategoryRepository $CategoryRepository
     * @return string
     */
    public function index(CategoryRepository $CategoryRepository){
        $categories = $CategoryRepository->findAll();
        return $this->render('index', ['categories' => $categories]);
    }

    /**
     * @param int $id
     * @param CategoryRepository $CategoryRepository
     */
    public function delete($id, CategoryRepository $CategoryRepository){
        $category = $CategoryRepository->getById($id);
        $category->delete();

        $this->setFlash('Category was successfully deleted');
        redirect('/category');
    }

    /**
     * @param CategoryRepository $CategoryRepository
     * @return string
     */
    public function add(CategoryRepository $CategoryRepository){
        $category = $this->createModelInstance("Category");

        return $this->processInput($category, $CategoryRepository, 'persistAdd');
    }

    /**
     * @param int $id
     * @param CategoryRepository $CategoryRepository
     * @return string
     */
    public function edit($id, CategoryRepository $CategoryRepository){
        $category = $CategoryRepository->getById($id);

        return $this->processInput($category, $CategoryRepository, 'persistEdit');
    }

    /**
     * @param ModelInterface|Category $category
     * @param CategoryRepository $CategoryRepository
     * @param string $persistMethod
     * @return string
     */
    private function processInput($category, $CategoryRepository, $persistMethod){
        $post = $this->getContainer()->getRequest()->inputPostAll();
        if(empty($post)){
            return $this->input($category, $CategoryRepository);
        }
        else{
            return $this->$persistMethod($category, $CategoryRepository);
        }
    }

    /**
     * @param ModelInterface|Category $category
     * @param CategoryRepository $CategoryRepository
     * @return string
     */
    protected function input($category, $CategoryRepository){
        $categories = $CategoryRepository->findAll();
        foreach($categories as $categoryKey => $categoryItem){
            /** @var Category $categoryItem */
            if($categoryItem->getId() == $category->getId()){
                unset($categories[$categoryKey]);
            }
        }
        return $this->render('input', ['category' => $category, 'categories' => $categories]);
    }

    /**
     * @param Category $category
     * @param CategoryRepository $CategoryRepository
     * @return null|string
     */
    protected function persistAdd($category, $CategoryRepository){
        $post = $this->getContainer()->getRequest()->inputPostAll();
        try {
            $category->fillData($post);
            $category->save();
        }
        catch(ValidationException $e){
            $this->setFlashError($e->getMessage());
            return $this->input($category, $CategoryRepository);
        }

        $this->setFlash('Category was successfully added');
        redirect('/category');
        return null;
    }

    /**
     * @param Category $category
     * @param CategoryRepository $CategoryRepository
     * @return null|string
     */
    protected function persistEdit($category, $CategoryRepository){
        $post = $this->getContainer()->getRequest()->inputPostAll();
        try {
            $category->fillData($post);
            $category->update();
        }
        catch(ValidationException $e){
            $this->setFlashError($e->getMessage());
            return $this->input($category, $CategoryRepository);
        }

        $this->setFlash('Category was successfully updated');
        redirect('/category');
        return null;
    }
}
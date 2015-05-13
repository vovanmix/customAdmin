<?php

namespace Vovanmix\CustomAdmin\Controllers;

use Vovanmix\CustomAdmin\Lib\Mvc\Controller;
use Vovanmix\CustomAdmin\Repositories\CategoryRepository;
use \Vovanmix\CustomAdmin\Models\Category;

class CategoryController extends Controller{

    public function index(CategoryRepository $CategoryRepository){
        $categories = $CategoryRepository->findAll();
        return $this->render('index', ['categories' => $categories]);
    }


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

    private function processInput($category, $CategoryRepository, $persistMethod){
        $post = $this->getContainer()->getRequest()->inputPostAll();
        if(empty($post)){
            return $this->input($category, $CategoryRepository);
        }
        else{
            return $this->$persistMethod($category);
        }
    }

    /**
     * @param Category $category
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
     * @return string
     */
    protected function persistAdd($category){
        $post = $this->getContainer()->getRequest()->inputPostAll();
        $category->fillData($post);
        $category->save();

        $this->setFlash('Category was successfully added');
        redirect('/category');
    }

    /**
     * @param Category $category
     * @return string
     */
    protected function persistEdit($category){
        $post = $this->getContainer()->getRequest()->inputPostAll();
        $category->fillData($post);
        $category->update();

        $this->setFlash('Category was successfully updated');
        redirect('/category');
    }
}
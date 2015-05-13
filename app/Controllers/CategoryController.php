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

        return $this->render('thankyou');
    }

    /**
     * @return string
     */
    public function add(CategoryRepository $CategoryRepository){
        $category = $this->createModelInstance("Category");
        $post = $this->getContainer()->getRequest()->inputPostAll();

        if(empty($post)){
            return $this->input($category, $CategoryRepository);
        }
        else{
            return $this->persistAdd($category);
        }

    }

    /**
     * @param int $id
     * @param CategoryRepository $CategoryRepository
     * @return string
     */
    public function edit($id, CategoryRepository $CategoryRepository){
        $category = $CategoryRepository->getById($id);
        $post = $this->getContainer()->getRequest()->inputPostAll();
        if(empty($post)){
            return $this->input($category, $CategoryRepository);
        }
        else{
            return $this->persistEdit($category);
        }

    }

    /**
     * @param Category $category
     * @param CategoryRepository $CategoryRepository
     * @return string
     */
    private function input($category, $CategoryRepository){
        $categories = $CategoryRepository->findAll();
        foreach($categories as $categoryKey => $categoryItem){
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
    private function persistAdd($category){
        $post = $this->getContainer()->getRequest()->inputPostAll();
        $category->fillData($post);
        $category->save();

        return $this->render('thankyou');
    }

    /**
     * @param Category $category
     * @return string
     */
    private function persistEdit($category){
        $post = $this->getContainer()->getRequest()->inputPostAll();
        $category->fillData($post);
        $category->update();

        return $this->render('thankyou');
    }
}
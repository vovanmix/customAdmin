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
    public function add(){
        $category = $this->createModelInstance("Category");
        $post = $this->getContainer()->getRequest()->inputPostAll();
var_dump($post);die();
        if(empty($post)){
            return $this->inputAdd($category);
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
            return $this->inputEdit($id, $category);
        }
        else{
            return $this->persistEdit($id, $category);
        }

    }

    /**
     * @param Category $category
     * @return string
     */
    private function inputAdd($category){
        return $this->render('input', ['category' => $category]);
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
     * @param int $id
     * @param Category $category
     * @return string
     */
    private function inputEdit($id, $category){
        return $this->render('input', ['category' => $category]);
    }

    /**
     * @param int $id
     * @param Category $category
     * @return string
     */
    private function persistEdit($id, $category){
        $post = $this->getContainer()->getRequest()->inputPostAll();
        $category->fillData($post);
        $category->update();

        return $this->render('thankyou');
    }
}
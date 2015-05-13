<?php

namespace Vovanmix\CustomAdmin\Controllers;

use Vovanmix\CustomAdmin\Lib\Mvc\Controller;
use Vovanmix\CustomAdmin\Repositories\CategoryRepository;

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

        $post = $this->getContainer()->getRequest()->inputPostAll();
        if(empty($post)){
            return $this->inputAdd();
        }
        else{
            return $this->persistAdd();
        }

    }

    /**
     * @param int $id
     * @param CategoryRepository $CategoryRepository
     * @return string
     */
    public function edit($id, CategoryRepository $CategoryRepository){

        $post = $this->getContainer()->getRequest()->inputPostAll();
        if(empty($post)){
            return $this->inputEdit($id, $CategoryRepository);
        }
        else{
            return $this->persistEdit($id, $CategoryRepository);
        }

    }

    /**
     * @return string
     */
    private function inputAdd(){
        return $this->render('input');
    }

    /**
     * @return string
     */
    private function persistAdd(){
        $post = $this->getContainer()->getRequest()->inputPostAll();
        $category = $this->createClassInstance("\\Vovanmix\\CustomAdmin\\Models\\Category");
        $category->fillData($post);
        $category->save();

        return $this->render('thankyou');
    }

    /**
     * @param int $id
     * @param CategoryRepository $CategoryRepository
     * @return string
     */
    private function inputEdit($id, $CategoryRepository){
        $category = $CategoryRepository->getById($id);
        $data = $category->compactData();
        return $this->render('input', $data);
    }

    /**
     * @param int $id
     * @param CategoryRepository $CategoryRepository
     * @return string
     */
    private function persistEdit($id, $CategoryRepository){
        $post = $this->getContainer()->getRequest()->inputPostAll();
        $category = $CategoryRepository->getById($id);
        $category->fillData($post);
        $category->update();

        return $this->render('thankyou');
    }
}
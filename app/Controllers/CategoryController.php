<?php

namespace Vovanmix\CustomAdmin\Controllers;

use Vovanmix\CustomAdmin\Lib\Mvc\Controller;
use Vovanmix\CustomAdmin\Repositories\CategoryRepository;

class CategoryController extends Controller{

    function index(CategoryRepository $CategoryRepository){
        $categories = $CategoryRepository->findAll();
        return $this->render('index', ['categories' => $categories]);
    }

    /**
     * @return string
     */
    function add(){

        $post = $this->getContainer()->getRequest()->inputPostAll();
        if(empty($post)){
            return $this->inputAdd();
        }
        else{
            return $this->persistAdd();
        }

    }

    /**
     * @return string
     */
    function inputAdd(){
        return $this->render('input');
    }

    /**
     * @return string
     */
    function persistAdd(){
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
    function edit($id, CategoryRepository $CategoryRepository){

        $post = $this->getContainer()->getRequest()->inputPostAll();
        if(empty($post)){
            return $this->inputEdit($id, $CategoryRepository);
        }
        else{
            return $this->persistEdit($id, $CategoryRepository);
        }

    }

    /**
     * @param int $id
     * @param CategoryRepository $CategoryRepository
     * @return string
     */
    function inputEdit($id, $CategoryRepository){
        $category = $CategoryRepository->getById($id);
        $data = $category->compactData();
        return $this->render('input', $data);
    }

    /**
     * @param int $id
     * @param CategoryRepository $CategoryRepository
     * @return string
     */
    function persistEdit($id, $CategoryRepository){
        $post = $this->getContainer()->getRequest()->inputPostAll();
        $category = $CategoryRepository->getById($id);
        $category->fillData($post);
        $category->update();

        return $this->render('thankyou');
    }

}
<?php

/* 
 * Click nbfs://nbhost/SystemFileSystem/Templates/Licenses/license-default.txt to change this license
 * Click nbfs://nbhost/SystemFileSystem/Templates/Scripting/EmptyPHP.php to edit this template
 */
include '../Database.php';
include '../comment.php';

$id = $_GET['id'];

$comment = new Comment();
$comment->delete($id);
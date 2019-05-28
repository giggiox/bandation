<?php
include '../../include/classes.php';
session_start();
UserProvider::Logout();
header("location:../../index.php");

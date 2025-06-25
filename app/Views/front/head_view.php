<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $title ?? 'TRY-HARDWARE' ?></title>
    
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">

    <script src="https://unpkg.com/lucide@latest"></script>

    <link rel="stylesheet" href="https://unpkg.com/swiper@10/swiper-bundle.min.css" />

    <link rel="preconnect" href="https://fonts.googleapis.com">

    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>

    <link href="https://fonts.googleapis.com/css2?family=Racing+Sans+One&display=swap" rel="stylesheet">
    
    <link rel="stylesheet" href="<?= base_url('assets/css/Estilo1.css') ?>"> 
    
    <link rel="stylesheet" href="<?= base_url('assets/css/admin_styles.css') ?>">

    <link rel="stylesheet" href="<?= base_url('assets/css/custom.css') ?>">
    
    <link rel="icon" type="image/icon" href="<?php echo base_url('assets/img/pc1.ico'); ?>" sizes="64x64">

    <meta name="csrf-token" content="<?= csrf_hash() ?>">

    
    
</head>
<body class="d-flex flex-column min-vh-100">

    
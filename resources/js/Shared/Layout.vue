<script setup>
import Header from './Header.vue';
import Footer from './Footer.vue';
</script>

<template>
    <div class="container">

        <Header/>
        <slot/>

        <Footer/>
    </div>
    </template>

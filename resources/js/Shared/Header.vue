<script setup>
import { Link } from '@inertiajs/vue3';
</script>
<template>
    <header class="d-flex flex-wrap justify-content-center py-3 mb-4 border-bottom">
        <a href="/" class="d-flex align-items-center mb-3 mb-md-0 me-md-auto link-body-emphasis text-decoration-none">
          <svg class="bi me-2" width="40" height="32"><use xlink:href="#bootstrap"/></svg>
          <span class="fs-4">Simple header</span>
        </a>

        <ul class="nav nav-pills">
          <li class="nav-item"><Link href="/" class="nav-link active" aria-current="page">Home</Link></li>
          <li class="nav-item"><Link href="/quiz" class="nav-link">Quiz</Link></li>
          <li class="nav-item"><Link href="/questions" class="nav-link">Questions</Link></li>


        </ul>
      </header>
</template>

<script setup>
import { Link , usePage } from '@inertiajs/vue3';
import { computed } from 'vue';

const page = usePage()
const appName = computed(()=>page.props.appName)
</script>
<template>
    <header class="d-flex flex-wrap justify-content-center py-3 mb-4 border-bottom bg-success">
        <a href="/" class="d-flex align-items-center mb-3 mb-md-0 me-md-auto link-body-emphasis text-decoration-none">
          <svg class="bi me-2" width="40" height="32"><use xlink:href="#bootstrap"/></svg>
          <span class="fs-4 text-white">{{ appName }}</span>
        </a>

        <ul class="nav nav-pills">
          <li class="nav-item"><Link href="/" :class="{'active':$page.url==='/'}" class="nav-link text-white" aria-current="page">Home</Link></li>
          <li class="nav-item"><Link href="/quiz" :class="{'active':$page.url==='/quiz'}" class="nav-link text-white">Quiz</Link></li>
          <li class="nav-item"><Link href="/questions"  :class="{'active':$page.url==='/questions'}" class="nav-link text-white">Questions</Link></li>
          <li class="nav-item"><Link href="/results"  :class="{'active':$page.url==='/results'}" class="nav-link text-white">Results</Link></li>
        </ul>
      </header>
</template>

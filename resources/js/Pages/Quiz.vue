<script setup>
import { router } from '@inertiajs/vue3';
import { computed, ref } from 'vue';
import Layout from '../Shared/Layout.vue';

const props=defineProps({
    questions:Object
})
const currentIndex=ref(0)

const currentQuestion = computed(()=>{
    return props.questions[currentIndex.value];
})

const answers = computed(()=>{
    return props.questions[currentIndex.value].answers
})

const totalQuestions = computed(()=>props.questions.length)

const isLastQuestion = computed(()=>currentIndex.value===props.questions.length-1)

const selectedAnswer=ref(null)

const result=ref(0)
const selectedOption = (index)=>{
    // alert(index)
    selectedAnswer.value=index
}
const nextQuestion = ()=>{
    if (selectedAnswer.value!=null) {
        if (props.questions[currentIndex.value].answers[selectedAnswer.value].correct_answer===1) {
            result.value++
        }
        currentIndex.value++
        selectedAnswer.value=null
    }
}

const calculateResult = ()=>{
    if (props.questions[currentIndex.value].answers[selectedAnswer.value].correct_answer===1) {
            result.value++
        }
    router.post('/results',[
        {
            results:{
                'score':result.value,
                'totalQuestions':totalQuestions.value
            }
        }
    ])
}
</script>
<template>

    <div>
        <Layout>
            <div class="d-flex justify-content-center">
               Question  {{ currentIndex+1 }} out of {{ totalQuestions }}
            </div>
            <div class="d-flex flex-column flex-md-row p-4 gap-4 py-md-5 align-items-center justify-content-center">
                <div class="list-group">
                  <a href="#" class="list-group-item list-group-item-action d-flex gap-3 py-3" aria-current="true">
                    <div class="d-flex gap-2 w-100 justify-content-between">
                      <div>
                        <h6 class="mb-0">{{currentQuestion.question}}</h6>
                      </div>
                    </div>
                  </a>
                  <a @click="selectedOption(index)" :class="{'selected':index===selectedAnswer}" href="#" v-for="(answer,index) in answers" :key="index" class="list-group-item list-group-item-action d-flex gap-3 py-3" aria-current="true">
                    <div class="d-flex gap-2 w-100 justify-content-between" >
                      <div >

                        <p class="mb-0 opacity-75">
                            {{ answer.Answer }}
                        </p>
                        </div>
                    </div>
                  </a>

                  <div class="mt-2">
                    <button @click="calculateResult" v-if="isLastQuestion" class=" mx-2 btn btn-success">Submit</button>
                    <button @click="nextQuestion" v-if="!isLastQuestion" class="btn btn-primary">Next</button>
                  </div>
                </div>
            </div>

        </Layout>
    </div>
</template>
<style scoped>
.selected{
    background-color: green;
    color: white;
}
</style>

<script setup>
import { router } from '@inertiajs/vue3';
import { ref } from 'vue';
import { usePage } from '@inertiajs/vue3';
import Layout from '../Shared/Layout.vue';
import NewQuestionModal from '../Shared/NewQuestionModal.vue'
import { computed } from 'vue';

const page = usePage()
const success  = computed(()=>page.props.flash.success)
const showNewQuestionModal=ref(false)
const createdQuestion=ref(null)
const newAnswers=ref([])
const selectedAnswer=ref(null)
let answerId =1;

const createQuestion = () => {
    showNewQuestionModal.value=true
}
const destroyModal = () =>{
    showNewQuestionModal.value=false
}
const addNewAnswer = ()=>{
    const newAnswer = {
        id : answerId++,
        answer:'',
        correct_answer:0
    }
    newAnswers.value.push(newAnswer)
}
const handleRadioToggle = (answerId)=>{
    selectedAnswer.value = answerId
    newAnswers.value.forEach(answer=>{
        if (answer.id===answerId) {
            answer.correct_answer=1
        }else {
            answer.correct_answer=0
        }
    })
}

const submitQuestion = ()=>{
   if (!createdQuestion.value) {
    alert('Question Cannot be empty')
    return false
   }
   if(!validateAnswers() && !answerCount()){
    alert('Fill all inputs before Submitting')
    return false
   }

   router.post('/questions',{
    question : createdQuestion.value,
    answers :newAnswers.value
   })

   router.on('success',()=>{
        createdQuestion.value = null,
        newAnswers.value=[]

   })
}

const validateAnswers = ()=>{
    for(const answer of newAnswers.value){
        if (answer.answer.trim()==='') {
            return false

        }
    }
    return true
}
const answerCount =  ()=>{
    if (newAnswers.length<4) {
        alert('Four answers required to submit')
    }else if(newAnswers,length===4){
        return true
    }
    return false
}
</script>
<template>
  <Layout>
    <button class="btn btn-success mb-2" @click="createQuestion">Create</button>
   <div
    class="table-responsive"
   >
    <table
        class="table table-light table-striped"
    >
        <thead>
            <tr>
                <th scope="col">Column 1</th>
                <th scope="col">Column 2</th>
                <th scope="col">Column 3</th>
            </tr>
        </thead>
        <tbody>
            <tr class="">
                <td scope="row">R1C1</td>
                <td>R1C2</td>
                <td>R1C3</td>
            </tr>

        </tbody>
    </table>
   </div>
   <Teleport to="body">
    <NewQuestionModal :show="showNewQuestionModal" @close="destroyModal">
        <template #header>
            <h5>Add New Question</h5>
        </template>
        <template #success>
            <div v-if="success" class="alert alert-success">{{ success }}</div>
        </template>
        <template #body>
            <div class="mb-3">
               <form action="" class="mb-2">
                <label for="question" class="form-label">Question</label>
                <input type="text" class="form-control" v-model="createdQuestion" id="question">
               </form>
               <div
                class="table-responsive"
               >
                <table
                    class="table table-light"
                >
                    <thead>
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">Answer</th>
                            <th scope="col">Correct ?</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="(answer) in newAnswers" :key="answer.id">
                            <td scope="row">{{answer.id}}</td>
                            <td>
                                <input type="text" v-model="answer.answer" class="form-control" id="answer">
                            </td>
                            <td>
                                <input type="radio" :checked="answer.correct_answer===1" :value="answer.id" @change="handleRadioToggle(answer.id)" class="form-check-input" id="radio">
                            </td>
                        </tr>

                    </tbody>
                </table>
               </div>

              </div>

        </template>
        <template #footer>
            <span @click="addNewAnswer" v-if="newAnswers.length < 4">
                <h3>+</h3>
            </span>
            <button @click="destroyModal" class="btn btn-danger me-1">Close</button>
            <button v-if="newAnswers.length>3"  @click="submitQuestion" class="btn btn-success">Submit</button>
        </template>
    </NewQuestionModal>
   </Teleport>
  </Layout>
</template>

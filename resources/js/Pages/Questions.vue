<script setup>
import { router } from '@inertiajs/vue3';
import { ref } from 'vue';
import { usePage } from '@inertiajs/vue3';
import Layout from '../Shared/Layout.vue';
import NewQuestionModal from '../Shared/NewQuestionModal.vue'
import { computed } from 'vue';

const page = usePage()
const success  = computed(()=>page.props.flash.success)
const showViewQuestionModal=ref(false)
const showNewQuestionModal=ref(false)
const createdQuestion=ref(null)
const newAnswers=ref([])
const answers=ref([])
const selectedAnswer=ref(null)
const selectedQuestion=ref(null)
let answerId =1;

const createQuestion = () => {
    showNewQuestionModal.value=true
}
const destroyModal = () =>{
    showNewQuestionModal.value=false
    showViewQuestionModal.value=false
    editQuestionModal.value=false
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

const selectedEditedAnswer=ref(null)
const handleRadioChange = (answerId)=>{
    selectedEditedAnswer.value=answerId

    answers.value.forEach(answer=>{
        if (answer.id ===  answerId) {
                answer.correct_answer=1
        }else{
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

const props =defineProps({
    questions:Object,
    error:Object
})


const viewQuestion = (index)=>{
    showViewQuestionModal.value=true
    selectedQuestion.value=props.questions[index]
    answers.value=props.questions[index].answers
}

const updateAnswers = ()=>{
    router.put('/answers',{
         answers : answers.value,

    })
}

const editQuestionModal=ref(false)
const questionForEdit =  ref(null)
const editQuestion= (index)=>{
    questionForEdit.value=props.questions[index]
    // alert(index)

}

const updateQuestion = ()=>{
   router.put('/questions',{
    questionForEdit : questionForEdit.value
   })
}
const deleteQuestion = (questionId)=>{
    // router.delete('/question/delete',)
    router.on('before',()=>{
        return confirm('You are about to delete a Record , are you sure ?')
    })
    router.delete('/questions/'+questionId)
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
                <th style="width: 10%;" scope="col">#</th>
                <th style="width: 70%;" scope="col">Question</th>
                <th scope="col">Action</th>
            </tr>
        </thead>
        <tbody>
            <tr v-for="(question,index) in questions" :key="question.id">
                <td scope="row">{{ index+1 }}</td>
                <td>{{ question.question }}</td>
                <td>
                    <button @click="viewQuestion(index)" class="btn btn-secondary btn-sm me-1">View</button>
                    <button @click="editQuestionModal=true,editQuestion(index)" class="btn btn-primary  btn-sm me-1">Edit</button>
                    <button @click="deleteQuestion(question.id)" class="btn btn-danger btn-sm">Delete</button>
                </td>
            </tr>

        </tbody>
    </table>
   </div>
   <Teleport to="body">
    <!-- New Question Add Modal  -->

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
 <!-- END  New Question Add Modal  -->

        <!-- Answer edit & view modal  -->
    <NewQuestionModal :show="showViewQuestionModal" @close="destroyModal">
        <template #header>
            <h5>View Question /  Answers </h5>
        </template>
        <template #success>
            <div v-if="success" class="alert alert-success">{{ success }}</div>
        </template>
        <template #body>
            <p><strong>Q. {{ selectedQuestion.question }}</strong></p>

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
                    <tr v-for="(answer,index) in selectedQuestion.answers" :key="answer.id">
                        <td scope="row">{{index+1}}</td>
                        <td>
                            <input type="text" v-model="answer.Answer" class="form-control" id="answer">
                        </td>
                        <td>
                            <input type="radio" :checked="answer.correct_answer===1" :value="answer.id" @change="handleRadioChange(answer.id)" class="form-check-input" id="radio">
                        </td>
                    </tr>

                </tbody>
            </table>
           </div>
        </template>
        <template #footer>
           <button @click="destroyModal" class="btn btn-danger">Close</button>
           <button  @click="updateAnswers" class="btn btn-success">Save</button>
        </template>
    </NewQuestionModal>
      <!-- end Answer edit & view modal  -->


      <!-- Edit Question Modal  -->
      <NewQuestionModal :show="editQuestionModal"   @close="destroyModal">
          <template #header>
            <h5>Edit  Question</h5>

          </template>
          <template #success>
            <div v-if="success" class="alert alert-success">{{ success }}</div>
          </template>
          <template #body>
            <div class="mb-3">
                <form action="" class="mb-2">
                    <label for="edit_question" class="form-label">Edit Question</label>
                    <input type="text" class="form-control" v-model="questionForEdit.question" id="edit_question">
                   </form>

            </div>
          </template>
          <template #footer>
            <button @click="editQuestionModal=false" class="btn btn-danger">Close</button>
           <button  @click="updateQuestion" class="btn btn-success">Save</button>
          </template>
    </NewQuestionModal>
      <!-- End Edit Question Modal  -->
   </Teleport>
  </Layout>
</template>

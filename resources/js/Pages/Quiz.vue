<template>
    <div class="p-6">
      <button 
        @click="showQuiz = true"
        class="px-4 py-2 bg-blue-500 text-white rounded hover:bg-blue-600"
      >
        Start Quiz
      </button>
  
      <TransitionRoot appear :show="showQuiz" as="template">
        <Dialog as="div" @close="showQuiz = false" class="relative z-10">
          <TransitionChild
            enter="ease-out duration-300"
            enter-from="opacity-0"
            enter-to="opacity-100"
            leave="ease-in duration-200"
            leave-from="opacity-100"
            leave-to="opacity-0"
          >
            <div class="fixed inset-0 bg-black bg-opacity-25" />
          </TransitionChild>
  
          <div class="fixed inset-0 overflow-y-auto">
            <div class="flex min-h-full items-center justify-center p-4">
              <TransitionChild
                enter="ease-out duration-300"
                enter-from="opacity-0 scale-95"
                enter-to="opacity-100 scale-100"
                leave="ease-in duration-200"
                leave-from="opacity-100 scale-100"
                leave-to="opacity-0 scale-95"
              >
                <DialogPanel class="w-full max-w-2xl transform overflow-hidden rounded-2xl bg-white p-6 shadow-xl transition-all">
                  <QuizComponent 
                    :questions="questions"
                    @complete="handleQuizComplete"
                    @close="showQuiz = false"
                  />
                </DialogPanel>
              </TransitionChild>
            </div>
          </div>
        </Dialog>
      </TransitionRoot>
    </div>
  </template>
  
  <script setup>
  import { ref, onMounted } from 'vue'
  import { TransitionRoot, TransitionChild, Dialog, DialogPanel } from '@headlessui/vue'
  import QuizComponent from '../Components/QuizComponent.vue'
  
  const props = defineProps({
    quizQuestions: {
      type: Array,
      required: true
    }
  })
  
  const showQuiz = ref(false)
  const questions = ref([])
  
  onMounted(() => {
    // Shuffle questions on component mount
    questions.value = [...props.quizQuestions]
      .sort(() => Math.random() - 0.5)
  })
  
  const handleQuizComplete = () => {
    setTimeout(() => {
      showQuiz.value = false
      // Re-shuffle questions for next attempt
      questions.value = [...props.quizQuestions]
        .sort(() => Math.random() - 0.5)
    }, 1500)
  }
  </script>
<template>
    <div>
      <div class="flex justify-between items-center mb-6">
        <h2 class="text-2xl font-bold">Quiz</h2>
        <button @click="$emit('close')" class="text-gray-500 hover:text-gray-700">
          <XIcon class="h-6 w-6" />
        </button>
      </div>
      
      <div v-if="currentQuestion" class="space-y-6">
        <div>
          <h3 class="text-lg font-medium mb-2">{{ currentQuestion.question }}</h3>
          
          <!-- Multiple Choice Question -->
          <div v-if="currentQuestion.type === 'multiple_choice'" class="space-y-2">
            <button
              v-for="option in currentQuestion.options"
              :key="option"
              @click="checkAnswer(option)"
              class="w-full p-3 text-left border rounded hover:bg-gray-100"
              :disabled="isChecking"
            >
              {{ option }}
            </button>
          </div>
  
          <!-- Free Text Question -->
          <div v-else>
            <input
              v-model="userAnswer"
              @keyup.enter="checkAnswer(userAnswer)"
              type="text"
              class="w-full p-2 border rounded"
              placeholder="Type your answer..."
              :disabled="isChecking"
            >
          </div>
  
          <!-- Hint -->
          <div v-if="currentQuestion.hint" class="mt-4">
            <button
              @click="showHint = !showHint"
              class="text-blue-500 hover:text-blue-700"
            >
              {{ showHint ? 'Hide Hint' : 'Show Hint' }}
            </button>
            <p v-if="showHint" class="mt-2 text-gray-600 italic">
              {{ currentQuestion.hint }}
            </p>
          </div>
  
          <!-- Feedback -->
          <div v-if="feedback" class="mt-4">
            <div :class="[
              'p-4 rounded',
              feedback.isCorrect ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-700'
            ]">
              {{ feedback.message }}
            </div>
          </div>
        </div>
  
      </div>
  
      <div v-else class="text-center py-8">
        <h3 class="text-xl font-bold mb-4">Geschafft! 🎉</h3>
        <button
          @click="$emit('close')"
          class="px-4 py-2 bg-blue-500 text-white rounded hover:bg-blue-600"
        >
          Close
        </button>
      </div>
    </div>
  </template>
  
  <script setup>
  import { ref, computed } from 'vue'
  import { XIcon } from '@heroicons/vue/outline'
  
  const props = defineProps({
    questions: {
      type: Array,
      required: true
    }
  })
  
  const emit = defineEmits(['close', 'complete'])
  
  const remainingQuestions = ref([...props.questions])
  const userAnswer = ref('')
  const showHint = ref(false)
  const feedback = ref(null)
  const isChecking = ref(false)
  
  const currentQuestion = computed(() => remainingQuestions.value[0])
  const totalQuestions = computed(() => props.questions.length)
  
  const checkAnswer = (answer) => {
    if (isChecking.value) return
    isChecking.value = true
    
    let isCorrect = false
    
    if (currentQuestion.value.type === 'multiple_choice') {
      isCorrect = answer === currentQuestion.value.correctAnswer
    } else {
      // Free text answer with fuzzy matching
      isCorrect = currentQuestion.value.correctAnswers.some(correctAnswer => {
      const similarity = calculateSimilarity(
        answer.toLowerCase(),
        correctAnswer.toLowerCase()
      )
      console.log(similarity)
      // Setze einen Default-Schwellenwert, falls keiner definiert ist.
      const threshold = currentQuestion.value.fuzzyThreshold ?? 0.5
      
      if (Array.isArray(similarity)) {
        return similarity.some(val => val >= threshold)
      }
      return similarity >= threshold
    })
    }
  
    feedback.value = {
      isCorrect,
      message: isCorrect ? 'Correct!' : 'Try again'
    }
    
    if (isCorrect) {
      setTimeout(() => {
        remainingQuestions.value.shift()
        userAnswer.value = ''
        showHint.value = false
        feedback.value = null
        
        if (remainingQuestions.value.length === 0) {
          emit('complete')
        }
      }, 1500)
    }
    
    isChecking.value = false
  }
  
  // Simple Levenshtein distance for fuzzy matching
  const calculateSimilarity = (str1, str2) => {
    const len1 = str1.length
    const len2 = str2.length
    const matrix = Array(len2 + 1).fill().map(() => Array(len1 + 1).fill(0))
    
    for (let i = 0; i <= len1; i++) matrix[0][i] = i
    for (let j = 0; j <= len2; j++) matrix[j][0] = j
    
    for (let j = 1; j <= len2; j++) {
      for (let i = 1; i <= len1; i++) {
        const cost = str1[i - 1] === str2[j - 1] ? 0 : 1
        matrix[j][i] = Math.min(
          matrix[j][i - 1] + 1,
          matrix[j - 1][i] + 1,
          matrix[j - 1][i - 1] + cost
        )
      }
    }
    
    const maxLength = Math.max(len1, len2)
    return (maxLength - matrix[len2][len1]) / maxLength
  }
  </script>
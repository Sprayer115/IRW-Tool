<template>
  <div class="cost-allocation">
    <h1 class="title">Kostenträgerrechnung - Verteilung der Kosten auf die Kostenträger</h1>
    <br>
    <p>
      Für die Kostenträgerrechnung nehmen wir an, dass es
      <strong>zwei Produkte</strong> (z. B. <strong>Produkt A</strong> und
      <strong>Produkt B</strong>) gibt. Die Verteilung der Kosten erfolgt auf
      Basis von <strong>proportionalen Schlüsselgrößen</strong>, z. B.
      Maschinenstunden oder Stückzahlen:
    </p>

    <ul>
      <li>
        <strong>Schlüssel für die Verteilung:</strong>
      </li>
      <li>
        <strong>Produktion:</strong> Produkt A = 60 %, Produkt B = 40 %
      </li>
      <li>
        <strong>Verwaltung und Vertrieb:</strong> Produkt A = 50 %, Produkt B = 50 %
      </li>
    </ul>

    <!-- Button-Gruppe: Skript- und Quiz-Button -->
    <div style="text-align: right; margin-top: 1rem;">
      <button class="btnShowScript" style="display: none;" @click="downloadScript">Skript</button>
      <button class="btnStartQuiz" @click="openQuiz">Quiz</button>
    </div>

    <!-- Modal: Quiz Component via Headless UI -->
    <TransitionRoot appear :show="showQuiz" as="template">
      <Dialog as="div" @close="closeQuiz" class="relative z-10">
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
                  :questions="quizQuestions" 
                  @complete="handleQuizComplete"
                  @close="closeQuiz" />
              </DialogPanel>
            </TransitionChild>
          </div>
        </div>
      </Dialog>
    </TransitionRoot>
  </div>
</template>

<script>
import axios from 'axios'
import QuizComponent from '../../../Components/Quiz.vue'
import { TransitionRoot, TransitionChild, Dialog, DialogPanel } from '@headlessui/vue'

export default {
  name: "CostAllocationKey",
  components: {
    TransitionRoot,
    TransitionChild,
    Dialog,
    DialogPanel,
    QuizComponent
  },
  data() {
    return {
      showQuiz: false,
      quizQuestions: []
    }
  },
  mounted() {
    this.fetchQuizQuestions()
  },
  methods: {
    downloadScript() {
      const link = document.createElement('a')
      link.href = '/storage/Kostentraeger.pdf'
      link.setAttribute('download', 'Kostentraeger.pdf')
      document.body.appendChild(link)
      link.click()
      document.body.removeChild(link)
    },
    openQuiz() {
      this.showQuiz = true
    },
    closeQuiz() {
      this.showQuiz = false
    },
    fetchQuizQuestions() {
      axios.get('/quiz/Kostentraeger.json')
        .then(response => {
          this.quizQuestions = response.data.questions || response.data
        })
        .catch(error => {
          console.error('Error fetching quiz questions:', error)
        })
    },
    handleQuizComplete() {
      setTimeout(() => {
        this.showQuiz = false
      }, 1500)
    }
  }
}
</script>

<style scoped>
.title {
  font-size: 1.4rem;
}
.cost-allocation {
  max-width: 700px;
  margin: 1rem auto;
  font-family: sans-serif;
  line-height: 1.5;
}

.cost-allocation p {
  margin-bottom: 1rem;
}

ul {
  list-style: disc; 
  margin-left: 1.5rem;
}

li {
  margin-bottom: 0.5rem;
}

/* Skript- und Quiz-Button-Stile */
.btnShowScript,
.btnStartQuiz {
  border: none;
  cursor: pointer;
  border-radius: 12px;
  margin: 5px;
  padding: 14px 28px;
  font-weight: 500;
}

.btnShowScript {
  background-color: #475569;
  color: rgb(226,232,240);
}

.btnShowScript:hover,
.btnStartQuiz:hover {
  opacity: 0.85;
}

.btnStartQuiz {
  background-color: #2563eb;
  color: white;
}

/* Headless UI Dialog */
.fixed {
  position: fixed;
}
</style>

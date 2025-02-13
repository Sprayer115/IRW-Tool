<template>
  <div class="db-ergebnis-container">
    <h2>Ergebnis der mehrstufigen Deckungsbeitragsrechnung</h2>
    <div class="tabelle-overflow">
    <table class="db-ergebnis-tabelle">
      <thead>
        <tr>
          <th>Stufe</th>
          <th>Produkt A (€)</th>
          <th>Produkt B (€)</th>
          <th>Gesamt (€)</th>
        </tr>
      </thead>
      <tbody>
        <tr>
          <td>DB I (einstufig)</td>
          <td>216.076,5</td>
          <td>128.623,5</td>
          <td>344.700</td>
        </tr>
        <tr>
          <td>DB II (nach Produktfixkosten)</td>
          <td>186.076,5</td>
          <td>108.623,5</td>
          <td>294.700</td>
        </tr>
        <tr>
          <td>DB III (nach Bereichsfixkosten)</td>
          <td>9.832,5</td>
          <td>5.867,5</td>
          <td>15.700</td>
        </tr>
        <tr>
          <td>DB IV (nach Unternehmensfixkosten)</td>
          <td>-21.738,5</td>
          <td>-12.561,5</td>
          <td>-34.300</td>
        </tr>
      </tbody>
    </table>

  </div>
    <!-- Button-Gruppe: Skript- und Quiz-Button -->
    <div style="text-align: right; margin-top: 1rem;">
      <button class="btnShowScript" @click="downloadScript">Skript</button>
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
import { onMounted } from 'vue'

export default {
  name: "MehrstufigeDBErgebnis",
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
      link.href = '/storage/DB-Rechnung.pdf'
      link.setAttribute('download', 'Deckungsbeitragsrechnung.pdf')
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
      axios.get('/quiz/Deckungsbeitrag.json')
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
.tabelle-overflow{
  overflow: auto;
}

.db-ergebnis-container {
  max-width: 700px;
  margin: 1rem auto;
  font-family: sans-serif;
}

.db-ergebnis-tabelle {
  width: 100%;
  border-collapse: collapse;
  text-align: left;
  margin-top: 1rem;
}

.db-ergebnis-tabelle th,
.db-ergebnis-tabelle td {
  border: 1px solid #ccc;
  padding: 8px 12px;
}

.db-ergebnis-tabelle thead tr {
  background-color: #f5f5f5;
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

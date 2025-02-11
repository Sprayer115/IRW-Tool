<!-- Finanzbuchhaltung/2.vue -->
<template>
  <div class="finanzbuchhaltung">
    <h1>Finanzbuchhaltung – Geschäftsbeispiele</h1>
    <ol>
      <li>
        Der Mietaufwand beträgt pro Jahr EUR 60.000; er ist bereits bezahlt worden.
      </li>
      <li>
        Der verbuchte Zinsaufwand für das erste Quartal beträgt EUR 6.000.
        Die kalkulatorischen Zinsen betragen 10 % des betriebsnotwendigen Kapitals 
        von EUR 477.000.
      </li>
      <li>
        Die Abschreibungen in der Finanzbuchhaltung betragen EUR 220.000 p.a. und
        werden jeweils am Jahresende gebucht. Die kalkulatorischen Abschreibungen
        betragen gemäß Anlagenkartei EUR 180.000 p.a.
      </li>
      <li>
        Im ersten Quartal wurden Computer als Handelsware für EUR 180.000 gekauft.
        Der Verbrauch zu Einstandspreisen lag bei EUR 160.000, zu Verrechnungspreisen
        bei EUR 170.000.
      </li>
      <li>
        Der Reparaturaufwand von EUR 21.000 geht unverändert in die Kostenrechnung ein.
      </li>
      <li>
        Die Versicherungsprämien betragen EUR 64.000 p.a. und sind bereits bezahlt
        und in der Finanzbuchhaltung verbucht.
      </li>
      <li>
        Die saisonal bedingten Aufwendungen für Werbung betragen für das erste Quartal EUR 48.000. Das Jahresbudget für Werbung beträgt EUR 120.000.
      </li>
      <li>
        In der Rechnungsperiode wurden die Einzellöhne von EUR 470.000 ausgezahlt, der effektive Wertverzehr (Kosten) für dieselbe Periode liegt bei EUR 490.000.
      </li>
    </ol>
    <div style="text-align: right;">
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
import QuizComponent from '../../Components/Quiz.vue'
import { TransitionRoot, TransitionChild, Dialog, DialogPanel } from '@headlessui/vue'
import { onMounted } from 'vue';

export default {
  components: {
    TransitionRoot,
    TransitionChild,
    Dialog,
    DialogPanel,
    QuizComponent
  },
  data() {
    return {
      pageData: '',
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
      link.href = '/storage/Finanzbuchhaltung.pdf'
      link.setAttribute('download', 'Finanzbuchhaltung.pdf')
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
      axios.get('/quiz/Finanzbuchhaltung.json')
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
.finanzbuchhaltung {
  max-width: 800px;
  margin: 1rem auto;
  font-family: sans-serif;
}

h1 {
  margin-bottom: 1rem;
}

ol {
  list-style-type: decimal;
  margin-left: 1.5rem;
}

li {
  margin-bottom: 0.5rem;
}

.btnShowScript {
  background-color: #475569;
  border-radius: 12px;
  margin: 5px;
  padding: 14px 28px;
  font-weight: 500;
  color: rgb(226, 232, 240);
}

.btnStartQuiz {
  background-color: #2563eb;
  border-radius: 12px;
  margin: 5px;
  padding: 14px 28px;
  font-weight: 500;
  color: white;
}

/* Styles für das Quiz Modal */
.fixed {
  position: fixed;
}
</style>
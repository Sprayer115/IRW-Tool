<template>
  <div class="kosten-tabelle">
    <table>
      <thead>
        <tr>
          <th>Kostenart</th>
          <th>Aufwand</th>
          <th>Zeitliche Abgrenzung</th>
          <th>Zeitlich abgegrenzter Aufwand</th>
          <th>Sachliche Abgrenzung</th>
          <th>Kosten</th>
        </tr>
      </thead>
      <tbody>
        <tr>
          <td>Miete</td>
          <td>60.000</td>
          <td>-45.000</td>
          <td>15.000</td>
          <td>0</td>
          <td>15.000</td>
        </tr>
        <tr>
          <td>Zinsen</td>
          <td>6.000</td>
          <td>0</td>
          <td>6.000</td>
          <td>5.925</td>
          <td>11.925</td>
        </tr>
        <tr>
          <td>Einzelmaterial</td>
          <td>160.000</td>
          <td>0</td>
          <td>160.000</td>
          <td>10.000</td>
          <td>170.000</td>
        </tr>
        <tr>
          <td>Abschreibungen</td>
          <td>55.000</td>
          <td>0</td>
          <td>55.000</td>
          <td>10.000</td>
          <td>45.000</td>
        </tr>
      </tbody>
    </table>

    <!-- Button-Gruppe: Skript- und Quiz-Button -->

  </div>
  <div class="button-group">
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
</template>

<script>
import axios from 'axios'
import QuizComponent from '../../Components/Quiz.vue'
import { TransitionRoot, TransitionChild, Dialog, DialogPanel } from '@headlessui/vue'
import { onMounted } from 'vue';

export default {
  name: "KostenAbgrenzungsTabelle",
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
    this.fetchQuizQuestions();
  },
  methods: {
    downloadScript() {
      const link = document.createElement('a');
      link.href = '/storage/Kostenartenrechnung.pdf';
      link.setAttribute('download', 'Kostenartenrechnung.pdf');
      document.body.appendChild(link);
      link.click();
      document.body.removeChild(link);
    },
    openQuiz() {
      this.showQuiz = true;
    },
    closeQuiz() {
      this.showQuiz = false;
    },
    fetchQuizQuestions() {
      axios.get('/quiz/Kostenarten.json')
        .then(response => {
          // Passe dies ggf. an die Struktur der JSON-Datei an
          this.quizQuestions = response.data.questions || response.data;
        })
        .catch(error => {
          console.error('Error fetching quiz questions:', error);
        });
    },
    handleQuizComplete() {
      setTimeout(() => {
        this.showQuiz = false;
      }, 1500);
    }
  }
}
</script>

<style scoped>
.kosten-tabelle {
  max-width: 800px;
  margin: 1rem auto;
  font-family: sans-serif;
  overflow: auto;
}

table {
  width: 100%;
  border-collapse: collapse;
  text-align: center;
}

thead tr {
  background-color: #e0e0e0;
}

th,
td {
  border: 1px solid #ccc;
  padding: 8px 12px;
}

/* Button-Gruppe */
.button-group {
  margin-top: 1rem;
  display: flex;
  justify-content: flex-end;
}

/* Skript-Button */
.btnShowScript,
.btnStartQuiz {
  border: none;
  cursor: pointer;
  border-radius: 12px;
  margin: 5px;
  padding: 14px 28px;
  font-weight: 500;
}

/* Skript-Button Style */
.btnShowScript {
  background-color: #475569;
  color: rgb(226,232,240);
}

/* Quiz-Button Style */
.btnStartQuiz {
  background-color: #2563eb;
  color: white;
}

/* Hover-Effekt */
.btnShowScript:hover,
.btnStartQuiz:hover {
  opacity: 0.85;
}

/* Headless UI Dialog */
.fixed {
  position: fixed;
}
</style>
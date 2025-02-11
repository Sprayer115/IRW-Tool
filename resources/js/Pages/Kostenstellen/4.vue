<template>
  <div class="gemeinkostenzuweisung">
    <h2><strong>Zuweisung der primären Gemeinkosten:</strong></h2>

    <!-- Wrapper, um Tabelle und Info-Button zusammen zu fassen -->
    <div class="table-wrapper">
      <table>
        <thead>
          <tr>
            <th>Kostenstelle</th>
            <th>Primäre Gemeinkosten (€)</th>
          </tr>
        </thead>
        <tbody>
          <tr>
            <td>Verwaltung</td>
            <td>76.200</td>
          </tr>
          <tr>
            <td>Produktion</td>
            <td>193.500</td>
          </tr>
          <tr>
            <td>Vertrieb</td>
            <td>48.000</td>
          </tr>
        </tbody>
      </table>

      <!-- Infobutton rechts, vertikal zentriert -->
      <div class="info-button" @click="onInfoClick" title="Mehr Informationen">
        i
      </div>
      <br>
      <!-- Button-Gruppe: Skript- und Quiz-Button -->
      <div style="text-align: right;">
        <button class="btnShowScript" @click="onShowScript">Skript</button>
        <button class="btnStartQuiz" @click="onQuiz">Quiz</button>
      </div>
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
  name: "GemeinkostenZuweisung",
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
    onInfoClick() {
      alert("Hier könnten weitere Informationen angezeigt werden!");
    },
    onShowScript() {
      const link = document.createElement('a');
      link.href = '/storage/Kostenstellen.pdf';
      link.setAttribute('download', 'Kostenstellen.pdf');
      document.body.appendChild(link);
      link.click();
      document.body.removeChild(link);
    },
    onQuiz() {
      this.showQuiz = true;
    },
    closeQuiz() {
      this.showQuiz = false;
    },
    fetchQuizQuestions() {
      axios.get('/quiz/Kostenstellen.json')
        .then(response => {
          // Passe dies ggf. an die Struktur Deiner JSON-Datei an
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
.gemeinkostenzuweisung {
  max-width: 600px;
  margin: 1rem auto;
  font-family: sans-serif;
}

/* Wrapper für Tabelle + Info-Button */
.table-wrapper {
  position: relative;
}

table {
  width: 100%;
  border-collapse: collapse;
  margin-top: 0.5rem;
  text-align: left;
}

thead tr {
  background-color: #f5f5f5;
}

th,
td {
  padding: 8px 12px;
  border: 1px solid #ccc;
}

th {
  font-weight: 600;
}

/* Infobutton: rechts, vertikal zentriert */
.info-button {
  position: absolute;
  top: 50%;
  right: -2rem;
  transform: translateY(-50%);
  width: 24px;
  height: 24px;
  background-color: #000;
  color: #fff;
  font-weight: bold;
  border-radius: 50%;
  display: flex;
  align-items: center;
  justify-content: center;
  cursor: pointer;
}

.info-button:hover {
  opacity: 0.85;
}

/* Skript- und Quiz-Buttons */
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

.btnStartQuiz {
  background-color: #2563eb;
  color: white;
}

/* Headless UI Dialog */
.fixed {
  position: fixed;
}
</style>

<template>
  <div class="gemeinkostenzuweisung">
    <h2><strong>Zuweisung der primären Gemeinkosten:</strong></h2>

    <!-- Wrapper, um Tabelle und Info-Button zusammen zu fassen -->
    <div class="table-wrapper">
      <div class="table-scroller">
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
    </div>
      <!-- Infobutton rechts, vertikal zentriert -->
      <div>
      <span id="tooltip-aufwand" class="tooltip-container">
            <sup class="info-button">i</sup>
            <span class="tooltip-text">Primäre Gemeinkosten sind jene Kosten, die aus externen Quellen <br>direkt in das Unternehmen einfließen und keinem bestimmten Produkt oder Auftrag direkt zugeordnet werden können. <br>Sie umfassen verschiedene Kategorien wie Miete, Zinsen, Abschreibungen und Versicherungen.<br><br>
            •	Miete: Wird oft nach genutzter Fläche aufgeteilt, z. B. zwischen Produktion und Verwaltung.<br>
            •	Zinsen: Verteilt sich basierend auf dem Kapitaleinsatz, also der finanziellen Ressourcennutzung.<br>
            •	Abschreibungen: Orientieren sich an den Anlagenwerten, da diese die langfristigen Investitionen widerspiegeln.<br>
            •	Versicherungen: Meist ebenfalls flächenbezogen verteilt, da sie für die Absicherung von Betriebsmitteln gelten.<br>
            •	Einzelmaterial und -löhne: Werden, wenn direkt zuordenbar, nicht in der <br>Kostenstellenrechnung berücksichtigt, sondern direkt den Kostenträgern zugeordnet.<br><br>
            &nbsp;Die Kostenstellenrechnung hilft dabei, diese Gemeinkosten verursachungsgerecht auf Kostenstellen<br> zu verteilen, um später eine präzise Zuweisung an die Kostenträger zu ermöglichen.
            </span>
      </span>
    </div>
      <br>
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
  position: absolute;
  left: 50%;
  transform: translate(-50%, -50%);
}

/* Optional: Hover-Effekt */
.info-button:hover {
  opacity: 0.85;
}
.tooltip-container:hover .tooltip-text {
    visibility: visible;
    opacity: 1;
    transition-delay: 0.1s; /* Delay before showing the tooltip */
    overflow: visible;
    left: -20rem;
    display: table;
}
.tooltip-container {
    position: absolute;
    display: block;
    cursor: pointer;
    top: 50%;
    right: -1rem;  /*Falls du mehr Platz willst, anpassen */
   transform: translateY(-50%);
   width: fit-content;
}
.tooltip-text {
    visibility: hidden;
    background-color: black;
    color: #fff;
    text-align: left;
    /*border-radius: 5px;*/
    padding: 5px;
    position: absolute;
    z-index: 1;
    top: 50%;
    /*bottom: 200%;  Adjust to position above the element */
    width: fit-content;
}
.table-scroller{
  overflow: auto;
}
</style>

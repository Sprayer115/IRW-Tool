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
        Die saisonal bedingten Aufwendungen für Werbung betragen für das
        erste Quartal EUR 48.000. Das Jahresbudget für Werbung beträgt EUR 120.000.
      </li>
      <li>
        In der Rechnungsperiode wurden die Einzellöhne von EUR 470.000 ausgezahlt,
        der effektive Wertverzehr (Kosten) für dieselbe Periode liegt bei EUR 490.000.
      </li>
    </ol>
    <div style="text-align: right;">
      <button class="btnShowScript" @click="downloadScript">Skript</button>
    </div>
  </div>
</template>
  
  <script>
  export default {
    data() {
      return {
        pageData: ''
      }
    },
    methods: {
      updateData() {
        this.$emit('update:modelValue', this.pageData)
      },
      downloadScript() {
        const link = document.createElement('a')
        link.href = '/storage/Finanzbuchhaltung.pdf'
        link.setAttribute('download', 'Finanzbuchhaltung.pdf')
        document.body.appendChild(link)
        link.click()
        document.body.removeChild(link)
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
  list-style-type: decimal; /* Nummerierte Aufzählung */
  margin-left: 1.5rem;
}

li {
  margin-bottom: 0.5rem;
}



.btnShowScript {
  background-color: #475569; /* bg-slate-600 */
  border-radius: 12px;
  margin: 5px;
  padding: 14px 28px;
  font-weight: 500;
  color: rgb(226 232 240);
  --tw-text-opacity: 1;
}
</style>
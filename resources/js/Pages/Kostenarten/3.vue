<!-- Kostenstellen/2.vue -->
<!-- Finanzbuchhaltung/1.vue -->
<template>
  <div class="cost-types">
    <h1>Einzel- und Gemeinkosten</h1>
    <br>
    <ol>
      <li>
        <strong>1. Einzelkosten:</strong><br />
        Direkt einem Produkt zuordenbar.<br />
        Beispiel: Materialkosten für ein Produkt.
      </li>
      <br>
      <li>
        <strong>2. Gemeinkosten:</strong><br />
        Nicht direkt einem Produkt zuordenbar.<br />
        Beispiel: Miete für ein Gebäude, das mehrere Abteilungen nutzt.
      </li>
    </ol>
    <br>
    <p>
      Die Kostenartenrechnung entnimmt die Kosten aus der Finanzbuchhaltung. Dort
      werden die Kosten neben der zeitlichen und sachlichen Abgrenzung ebenfalls
      in Einzel- und Gemeinkosten aufgeteilt. Die Einzelkosten werden direkt
      einem Kostenträger zugeordnet, während die Gemeinkosten in die
      Kostenstellenrechnung miteinfließen.
    </p>
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
      }
    }
  }
  </script>
<style scoped>
.cost-types {
  max-width: 700px;
  margin: 1rem auto;
  font-family: sans-serif;
}
ol {
  margin-left: 1.5rem;
}
</style>
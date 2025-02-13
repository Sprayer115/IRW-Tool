<template>
  <div class="kurzes-beispiel">
    <h2><strong>Kurzes Beispiel</strong></h2> <br>
    <p>
      Ein Unternehmen verteilt Mietkosten von 6.667 € nach genutzter Fläche:
    </p>
    <ul>
      <li>Produktion (60 %): 4.000 €</li>
      <li>Verwaltung (30 %): 2.000 €</li>
      <li>Vertrieb (10 %): 667 €</li>
    </ul>
    <p>So wird ermittelt, welcher Bereich die Kosten verursacht hat.</p>
    <br>
    <p>
      Die Kostenstellenrechnung teilt die Gemeinkosten in die verschiedenen 
      Kostenstellen nach dem Verursacherprinzip und bietet so eine gute Basis 
      für die spätere Verrechnung auf die Kostenträger.
    </p>
  </div>
</template>

<script>
export default {
  name: "KurzesBeispiel"
};
</script>

<style scoped>
.kurzes-beispiel {
  max-width: 600px;
  margin: 1rem auto;
  font-family: sans-serif;
}

ul {
  list-style-type: disc;
  margin-left: 1.5rem;
}
</style>

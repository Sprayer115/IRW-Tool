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
  </div>
</template>

<script>
export default {
  name: "CostAllocationKey"
};
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
</style>

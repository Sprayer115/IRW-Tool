export const topicConfigs = {
    finanzbuchhaltung: {
      title: 'Finanzbuchhaltung',
      pages: () => ({
        components: {
          'grundlagen': () => import('@/Pages/Finanzbuchhaltung/1.vue'),
          'buchungen': () => import('@/Pages/Finanzbuchhaltung/2.vue'),
          'abschluss': () => import('@/Pages/Finanzbuchhaltung/3.vue'),
          'auswertung': () => import('@/Pages/Finanzbuchhaltung/4.vue'),
        }
      })
    },
    kostenarten: {
      title: 'Kostenarten',
      pages: () => ({
        components: {
          'info': () => import('@/Pages/Kostenarten/Info.vue'),
          'abgrenzung': () => import('@/Pages/Kostenarten/Abgrenzung.vue'),
        }
      })
    },
    kostenstellen: {
      title: 'Kostenstellen',
      pages: () => ({
        components: {
          'info': () => import('@/Pages/Kostenstellen/Info.vue'),
          'iblv': () => import('@/Pages/Kostenstellen/InnerbetrieblicheLeistungsverrechnung.vue'),
          'msr': () => import('@/Pages/Kostenstellen/Maschinenstundenrechnung.vue'),
        }
      })
    },
    kostentraeger: {
        title: 'Kostenträger',
        pages: () => ({
          components: {
            'info': () => import('@/Pages/Kostentraeger/Info.vue'),
            'zuschlag': () => import('@/Pages/Kostentraeger/Zuschlag.vue'),
            'verteilung': () => import('@/Pages/Kostentraeger/Verteilung.vue')
          }
        })
    },
    deckungsbeitrag: {
        title: 'Deckungsbeitrag',
        pages: () => ({
          components: {
            'einstufig': () => import('@/Pages/Deckungsbeitrag/EinstufigeDB.vue'),
            'mehrstufig': () => import('@/Pages/Deckungsbeitrag/MehrstufigeDB.vue'),
            'preisuntergrenze': () => import('@/Pages/Deckungsbeitrag/Preisuntergrenzenrechnung.vue'),
            'break-even': () => import('@/Pages/Deckungsbeitrag/BreakEven.vue'),
            'optimierung': () => import('@/Pages/Deckungsbeitrag/OptProduktionsprogramm.vue'),
            'make-or-buy': () => import('@/Pages/Deckungsbeitrag/MakeOrBuy.vue'),
          }
        })
    }
    // Add other topics matching your navigation
  }
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
          'info': () => import('@/Pages/Kostenstellen/1.vue'),
          'iblv': () => import('@/Pages/Kostenstellen/2.vue'),
          'maschinenstunden': () => import('@/Pages/Kostenstellen/3.vue'),
        }
      })
    },
    kostentraeger: {
        title: 'Kostentraeger',
        pages: () => ({
          components: {
            'info': () => import('@/Pages/Kostentraeger/1.vue'),
            'zuschlag': () => import('@/Pages/Kostentraeger/2.vue'),
            'verteilung': () => import('@/Pages/Kostentraeger/3.vue')
          }
        })
    },
    deckungsbeitrag: {
        title: 'Deckungsbeitrag',
        pages: () => ({
          components: {
            'einstufig': () => import('@/Pages/deckungsbeitrag/EinstufigeDB.vue'),
            'mehrstufig': () => import('@/Pages/deckungsbeitrag/MehrstufigeDB.vue'),
            'preisuntergrenze': () => import('@/Pages/deckungsbeitrag/Preisuntergrenzenrechnung.vue'),
            'break-even': () => import('@/Pages/deckungsbeitrag/BreakEven.vue'),
            'optimierung': () => import('@/Pages/deckungsbeitrag/OptProduktionsprogramm.vue'),
            'make-or-buy': () => import('@/Pages/deckungsbeitrag/MakeOrBuy.vue'),
          }
        })
    }
    // Add other topics matching your navigation
  }
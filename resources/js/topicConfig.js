export const topicConfigs = {
    finanzbuchhaltung: {
      title: 'Finanzbuchhaltung',
      pages: () => ({
        components: [
          import('@/Pages/Finanzbuchhaltung/1.vue'),
          import('@/Pages/Finanzbuchhaltung/2.vue'),
          import('@/Pages/Finanzbuchhaltung/3.vue'),
          import('@/Pages/Finanzbuchhaltung/4.vue'),
          // Add more pages
        ]
      })
    },
    kostenarten: {
      title: 'Kostenarten',
      pages: () => ({
        components: [
          import('@/Pages/Kostenarten/1.vue'),
          import('@/Pages/Kostenarten/2.vue'),
          import('@/Pages/Kostenarten/3.vue'),
          import('@/Pages/Kostenarten/4.vue'),
          // Add more pages
        ]
      })
    },
    kostenstellen : {
        title: 'Kostenstellen',
        pages: () => ({
            components: [
            import('@/Pages/Kostenstellen/1.vue'),
            import('@/Pages/Kostenstellen/2.vue'),
            import('@/Pages/Kostenstellen/3.vue'),
            import('@/Pages/Kostenstellen/4.vue'),
            // Add more pages
            ]
        })
    },
    kostentraeger: {
        title: 'Kostentraeger',
        pages: () => ({
            components: [
            import('@/Pages/Kostentraeger/1.vue'),
            import('@/Pages/Kostentraeger/2.vue'),
            import('@/Pages/Kostentraeger/3.vue'),
            import('@/Pages/Kostentraeger/4.vue'),
            // Add more pages
            ]
        })
    }
    // Add other topics matching your navigation
  }
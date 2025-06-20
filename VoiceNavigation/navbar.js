let zoomLevel = 1;
if(annyang){
    console.log("Voice activated ✅");
    const zoomCommands = {
    'zoom in': () => {
      zoomLevel += 0.1;
      document.body.style.zoom = zoomLevel;
    },
    'zoom out': () => {
      zoomLevel = Math.max(0.5, zoomLevel - 0.1); // prevent too small
      document.body.style.zoom = zoomLevel;
    },
    'reset zoom': () => {
      zoomLevel = 1;
      document.body.style.zoom = 1;
    }
  };

  annyang.addCommands(zoomCommands);
    var commands = {
        // Home
        'go to home': () => document.getElementById('nav-home').click(),
        'open home': () => document.getElementById('nav-home').click(),

        // Shop
        'go to shop': () => document.getElementById('nav-shop').click(),
        'open shop': () => document.getElementById('nav-shop').click(),
        'show products': () => document.getElementById('nav-shop').click(),

        // Cart
        'go to cart': () => document.getElementById('nav-cart').click(),
        'open cart': () => document.getElementById('nav-cart').click(),
        'show my cart': () => document.getElementById('nav-cart').click(),

        // Stories
        'go to stories': () => document.getElementById('nav-stories').click(),
        'open stories': () => document.getElementById('nav-stories').click(),

        // Donate
        'go to donate': () => document.getElementById('nav-donate').click(),
        'open donate': () => document.getElementById('nav-donate').click(),
        'donation page': () => document.getElementById('nav-donate').click(),

        // Scroll down
        'scroll down': () => window.scrollBy({ top: 500, behavior: 'smooth' }),
        'go down': () => window.scrollBy({ top: 500, behavior: 'smooth' }),
        'move down': () => window.scrollBy({ top: 500, behavior: 'smooth' }),

        // Scroll up
        'scroll up': () => window.scrollBy({ top: -500, behavior: 'smooth' }),
        'go up': () => window.scrollBy({ top: -500, behavior: 'smooth' }),
        'move up': () => window.scrollBy({ top: -500, behavior: 'smooth' }),

            'go to profile': function() {
                const profileBtn = document.getElementById("profile-btn");
                if (profileBtn) {
                    profileBtn.click(); // 🔥 This simulates a click on the profile icon
                }
            },
            'open profile': function() {
                const profileBtn = document.getElementById("profile-btn");
                if (profileBtn) {
                    profileBtn.click(); // 🔥 This simulates a click on the profile icon
                }
            },
            'show profile': function() {
                const profileBtn = document.getElementById("profile-btn");
                if (profileBtn) {
                    profileBtn.click(); // 🔥 This simulates a click on the profile icon
                }
            },
            'my profile': function() {
                const profileBtn = document.getElementById("profile-btn");
                if (profileBtn) {
                    profileBtn.click(); // 🔥 This simulates a click on the profile icon
                }
            },
            'profile': function() {
                const profileBtn = document.getElementById("profile-btn");
                if (profileBtn) {
                    profileBtn.click(); // 🔥 This simulates a click on the profile icon
                }
            },

            'go to my products details': function() {
                const btn = document.getElementById("my-products-btn");
                if (btn) {
                    btn.click(); // Simulate button click
                }
            },
            'go to my product details': function() {
                const btn = document.getElementById("my-products-btn");
                if (btn) {
                    btn.click(); // Simulate button click
                }
            }
    };
    annyang.addCommands(commands);
    annyang.start({ autoRestart: true, continuous: false });
}
if ('webkitSpeechRecognition' in window && 'speechSynthesis' in window) {
    const recognition = new webkitSpeechRecognition();
    recognition.continuous = false;
    recognition.lang = "en-US";
    recognition.interimResults = false;
    recognition.maxAlternatives = 1;

    function speak(text) {
        const msg = new SpeechSynthesisUtterance();
        msg.text = text;
        msg.lang = "en-US";
        window.speechSynthesis.speak(msg);
    }

    function startVoiceInput() {
        recognition.start();
        console.log("Voice recognition started...");
        // speak("Voice recognition started. Please say a command.");
    }

    recognition.onresult = function(event) {
        const speech = event.results[0][0].transcript.toLowerCase();
        console.log("Heard:", speech);

        if (speech.startsWith("enter username")) {
            const username = speech.replace("enter username", "").trim();
            if (username.length > 0) {
                document.querySelector('input[name="username"]').value = username;
                speak("Username entered: " + username);
            } else {
                speak("Please say a valid username.");
            }
        } else if (speech.startsWith("enter password")) {
            const password = speech.replace("enter password", "").trim();
            if (password.length > 0) {
                document.querySelector('input[name="password"]').value = password;
                speak("Password entered.");
            } else {
                speak("Please say a valid password.");
            }
        } else if (speech === "click login" || speech === "login") {
            const loginBtn = document.getElementById("loginBtn");
            if (loginBtn) {
                loginBtn.click();
                speak("Logging in.");
            } else {
                speak("Login button not found.");
            }
        } else {
            speak("Command not recognized: " + speech);
        }
    };

    recognition.onerror = function(event) {
        console.error("Speech recognition error", event.error);
        speak("There was an error with voice recognition.");
    }
} else {
    alert("Your browser does not support Speech Recognition or Speech Synthesis. Try using Google Chrome.");
}
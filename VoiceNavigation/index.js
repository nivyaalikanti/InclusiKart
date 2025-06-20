
// if ('webkitSpeechRecognition' in window) {
//     const recognition = new webkitSpeechRecognition();
//     recognition.continuous = false;
//     recognition.lang = "en-US";
//     recognition.interimResults = false;
//     recognition.maxAlternatives = 1;

//     // Start voice recognition
//     function startListening() {
//         recognition.start();
//         console.log("Voice recognition started...");
//     }
//     function provideFeedback(message) {
//     const feedbackDiv = document.getElementById('voice-feedback');
//     if (feedbackDiv) {
//         feedbackDiv.textContent = message;
//     }
// }
// function speakFeedback(message) {
//     if ('speechSynthesis' in window) {
//         const utterance = new SpeechSynthesisUtterance(message);
//         utterance.lang = "en-US";
//         window.speechSynthesis.speak(utterance);
//     } else {
//         console.log("Speech Synthesis not supported.");
//     }
// }


//     // When result is captured
//     recognition.onresult = function(event) {
//         const command = event.results[0][0].transcript.toLowerCase();
//         console.log("Voice command received:", command);

//         if (command.includes("home")) {
            
//             setTimeout(() => {
//                 window.location.href = "index.php";
//             }, 1000);
//             speakFeedback("You are on the home page now.");
            
//         } else if (command.includes("profile")) {
//             window.location.href = "profile.php";
//         } else if (command.includes("submit verification")) {
//             window.location.href = "submit_verification.php";
//         } else if (command.includes("shop")) {
            
//             setTimeout(() => {
//                 window.location.href = "shop.php";
//             }, 1000);
//             speakFeedback("You are on the shop page now.");
//         } else if (command.includes("seller login")) {
//             window.location.href = "login.php";
//         } else if(command.includes("buyer login")){
//             setTimeout(() => {
//                 window.location.href = "blogin.php";
//             }, 1000);
//             speakFeedback("You are on the buyer login page now.");
//         }else if (command.includes("scroll down")) {
//             window.scrollBy({ top: 400, behavior: 'smooth' });
//             console.log("Scrolling down...");
//         } else if (command.includes("scroll up")) {
//             window.scrollBy({ top: -400, behavior: 'smooth' });
//             console.log("Scrolling up...");
//         } else {
//             alert("Command not recognized: " + command);
//         }
//     };

//     recognition.onerror = function(event) {
//         console.error("Speech recognition error", event.error);
//     }
// } else {
//     alert("Your browser does not support Speech Recognition. Try using Chrome.");
// }

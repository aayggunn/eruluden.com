 function validateEmail() {
      var emailInput = document.getElementById("email").value;
      var emailPattern = /^[a-zA-Z0-9._%+-]+@erciyes\.edu\.tr$/;
      
      if (emailPattern.test(emailInput)) {
        alert("Hesap doğrulandı: " + emailInput);
      } else {
        alert("Geçerli bir @erciyes.edu.tr mail adresi giriniz.");
      }
    }
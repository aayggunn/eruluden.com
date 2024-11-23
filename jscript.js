
document.addEventListener("DOMContentLoaded", function() {
  const features = document.querySelectorAll('.feature');
  const sectionHeight = window.innerHeight; // Section yüksekliği ekranın yüksekliğine eşit

  // Intersection Observer ile opacity kontrolü
  const observer = new IntersectionObserver((entries, observer) => {
    entries.forEach(entry => {
      if (entry.isIntersecting) {
        entry.target.style.opacity = 1;
      } else {
        entry.target.style.opacity = 0;
      }
    });
  }, { threshold: 0.5 }); // Threshold değeri %50 olarak ayarlandı

  // Her bir feature için gözlemciyi başlat
  features.forEach(feature => {
    observer.observe(feature);
  });
});



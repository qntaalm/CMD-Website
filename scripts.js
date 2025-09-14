document.addEventListener("DOMContentLoaded", () => {
    const head = document.querySelector('.steaveHead');
    const sound = document.getElementById('clickSound');
  
    if (head && sound) {
      head.addEventListener('click', () => {
        sound.currentTime = 0;
        sound.play();
        head.classList.add('jump');
        setTimeout(() => head.classList.remove('jump'), 400);
      });
    }
  
    // صوت عند الضغط على الروابط قبل الانتقال
    const links = document.querySelectorAll('.linkEffect a');
    const linkSound = document.getElementById('linkClickSound');
  
    if (linkSound) {
      links.forEach(link => {
        link.addEventListener('click', (e) => {
          e.preventDefault(); // نمنع التنقل الفوري
          const target = link.getAttribute('href'); // نحفظ الرابط
  
          linkSound.currentTime = 0;
          linkSound.play();
  
          setTimeout(() => {
            window.location.href = target; // ننتقل بعد 100ms
          }, 100);
        });
      });
    }
  });
  
  document.addEventListener('DOMContentLoaded', function() {
    const themeToggle = document.getElementById('themeToggle');
    const body = document.body;
    
    // تحميل الثيم المحفوظ
    const savedTheme = localStorage.getItem('theme');
    if (savedTheme === 'light') {
      body.classList.add('light-theme');
    }
    
    // حدث النقر
    themeToggle.addEventListener('click', function() {
      // تبديل الثيم مع التأثيرات
      if (body.classList.contains('light-theme')) {
        // الانتقال إلى الوضع الداكن
        body.classList.remove('light-theme');
        localStorage.setItem('theme', 'dark');
      } else {
        // الانتقال إلى الوضع الفاتح
        body.classList.add('light-theme');
        localStorage.setItem('theme', 'light');
      }
    });
  });

  document.addEventListener('DOMContentLoaded', function() {
    const portalImage = document.getElementById('portalImage');
    const portalSound = document.getElementById('portalSound');
    let isOriginalImage = true;
    
    // الصور والأصوات
    const media = {
      original: {
        image: 'assets/imgs/nether-portal.gif',
        sound: 'assets/audio/click.mp3'
      },
      alternate: {
        image: 'assets/imgs/nether-portal2.png',
        sound: 'assets/audio/portal.mp3'
      }
    };
  
    portalImage.addEventListener('click', function() {
      // تشغيل الصوت المناسب
      const soundToPlay = isOriginalImage ? media.original.sound : media.alternate.sound;
      portalSound.src = soundToPlay;
      portalSound.play()
        .catch(e => console.log("لا يمكن تشغيل الصوت:", e));
      
      // تبديل الصورة
      portalImage.src = isOriginalImage ? media.alternate.image : media.original.image;
      portalImage.alt = isOriginalImage ? "Nether Portal Activated" : "Nether Portal";
      
      // تأثيرات بصرية
      portalImage.style.transform = 'translate(-50%, -50%) scale(1.1)';
      setTimeout(() => {
        portalImage.style.transform = 'translate(-50%, -50%) scale(1)';
      }, 300);
      
      isOriginalImage = !isOriginalImage;
    });
  });

  window.addEventListener("load", () => {
    const loader = document.getElementById("loadingScreen");
    setTimeout(() => {
      loader.style.opacity = "0";
      loader.style.transition = "opacity 0.5s ease";
      setTimeout(() => loader.style.display = "none", 500);
    }, 2400); // مدة الانتظار 2 ثانية
  });

  const blockImages = [
    "assets/imgs/tnt.png",
    "assets/imgs/grass.png",
    "assets/imgs/creeper1.png",
    "assets/imgs/goldenapple.png",
    "assets/imgs/goldenappleM.png",
    "assets/imgs/diamond.png",
    "assets/imgs/homeV.png",
    "assets/imgs/golem.png",
    "assets/imgs/lava.png",
    "assets/imgs/totem.png",
    "assets/imgs/villgar.png"
  ];
  
  function createFallingBlock() {
    const block = document.createElement("img");
    block.src = blockImages[Math.floor(Math.random() * blockImages.length)];
    block.classList.add("fallingBlock");
    block.style.left = Math.random() * 100 + "vw";
    block.style.animationDuration = (5 + Math.random() * 5) + "s";
    block.style.transform = `scale(${0.6 + Math.random() * 0.5})`;
  
    document.getElementById("fallingBlocksContainer").appendChild(block);
  
    setTimeout(() => {
      block.remove();
    }, 10000);
  }
  
  setInterval(createFallingBlock, 500);
  
window.Alpine.data('copyTextButton', (text) => ({
    text: text,

    copyText($event) {
        navigator.clipboard.writeText(this.text).then(() => { 
          let originalText = $event.target.innerText; 
          $event.target.innerText = 'Copied!';
          setTimeout(() => { $event.target.innerText = originalText; }, 2000);
      });
    },
}));
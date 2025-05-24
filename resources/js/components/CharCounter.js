window.Alpine.data('charCounter', (maxLength = 100) => ({
    maxLength: maxLength,
    charCount: 0,
    overMaxLength: false,

    charCountMarkup: '',

    init() {
        this.setCharCountMarkup();
    },

    setCharCountMarkup() {
        this.charCountMarkup = `${this.charCount} / ${this.maxLength}`;
    },

    updateCharCount(text = '') {
        this.charCount = text.length;
        this.overMaxLength = this.charCount > this.maxLength;
        this.setCharCountMarkup();
    },
}));
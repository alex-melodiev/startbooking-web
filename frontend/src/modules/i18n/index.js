import Vue from 'vue';
import VueI18n from 'vue-i18n';
Vue.use(VueI18n);

export const Locales = [
  {
    'code': 'ru',
    'name': 'Русский',
  },
  {
    'code': 'en',
    'name': 'English',
  },
  {
    'code': 'uz',
    'name': 'O\'zbekcha',
  }
];

function loadLocaleMessages () {
  const locales = require.context('./locales', true, /[A-Za-z0-9-_,\s]+\.json$/i);
  const messages = {};
  locales.keys().forEach(key => {
    const matched = key.match(/([A-Za-z0-9-_]+)\./i);
    if (matched && matched.length > 1) {
      const locale = matched[1];
      messages[locale] = locales(key);
    }
  });
  return messages;
}

export function checkDefaultLanguage() {
    let matched = null
    let languages = Object.getOwnPropertyNames(loadLocaleMessages())
    languages.forEach(lang => {
        if (lang === navigator.language) {
            matched = lang
        }
    })
    if (!matched) {
        languages.forEach(lang => {
            let languagePartials = navigator.language.split('-')[0]
            if (lang === languagePartials) {
                matched = lang
            }
        })
    }
    if (!matched) {
        languages.forEach(lang => {
            let languagePartials = navigator.language.split('-')[0]
            if (lang.split('-')[0] === languagePartials) {
                matched = lang
            }
        })
    }
    return matched
}

export const selectedLocale =
    checkDefaultLanguage() || process.env.VUE_APP_I18N_LOCALE || 'ru';

export default new VueI18n({
  locale: selectedLocale,
  fallbackLocale: process.env.VUE_APP_I18N_FALLBACK_LOCALE || 'ru',
  messages: loadLocaleMessages()
});

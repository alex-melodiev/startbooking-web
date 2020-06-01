import i18n from "../../modules/i18n";
const { locale } = i18n;

export default function guest ({ next, store }){
  if(!store.getters['user/isGuest']){
    return next({
      name: 'home',
      params: {
        lang: locale
      }
    })
  }

  return next()
}

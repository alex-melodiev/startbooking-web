import i18n from "../../modules/i18n";
const { locale } = i18n;

export default function auth ({ next, to, store }){
  if(store.getters['user/isGuest']){
    return next({
      name: 'login',
      query: { backto: to.path },
      params: {
        lang: locale
      }
    })
  }

  return next()
}

import {isNotEmpty} from "../../../utils/helpers";
import i18n from "../../i18n";

export default {
  isLoading: (state) => state.isLoading,
  isSubmitting: (state) => state.isSubmitting,
  errors: (state) => state.errors,
  deal: (state) => state.deal,
  getDaysCount: (state) => state.daysCount,
  //getBookingDetails: (state) => state.bookingDetails,
  getAmount: (state) => state.daysCount * state.deal.price,
  getNds: (state) => state.daysCount * state.deal.price * 0.2,
  getSubtotal: (state) => (state.daysCount * state.deal.price * 0.2) + (state.daysCount * state.deal.price),
  getTotalNow: (state) => ((state.daysCount * state.deal.price * 0.2) + (state.daysCount * state.deal.price)) * 0.3,
  getTotalAfter: (state) => ((state.daysCount * state.deal.price * 0.2) + (state.daysCount * state.deal.price)) * 0.7,
  getTotal: (state) => state.total,
  item: (state) => {
    let result = null;
    if(isNotEmpty(state.deal)) {
      result = {
        id: state.deal.id,
        name: state.deal.name,
        cover_photo: state.deal.cover_photo,
        images: state.deal.images,
        avg_rating: state.deal.avg_rating,
        overall_rating: state.deal.overall_rating,
        reviews_count: state.deal.reviews_count,
        fee_starts_from: state.deal.fee_starts_from,
        description: state.deal.description
      }
    }
    return result;
  },
  crumbs: (state) => {
    let result = null;
    if(isNotEmpty(state.deal)) {
      result = [
        {name: state.deal.name, to: { name: 'deals-view', params: { id: state.deal.id }} },
        {name: i18n.t('Бронирование')}
      ]
    }
    return result;
  }
};

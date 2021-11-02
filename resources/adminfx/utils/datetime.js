import * as moment from 'moment';

export const FormatString = (date, format) => {
  return moment(date).format(format);
};
export default {};

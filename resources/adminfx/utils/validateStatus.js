import { HTTP_RESPONSE } from '@/common/constant/index';

export const validateStatus = (status) => (HTTP_RESPONSE.SUCCESS === status
  || HTTP_RESPONSE.SUCCESS_201 === status
  || HTTP_RESPONSE.ERROR_CODE_400 === status
  || HTTP_RESPONSE.ERROR_CODE_401 === status
  || HTTP_RESPONSE.ERROR_CODE_500 === status);
export default validateStatus;

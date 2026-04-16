import axios from "axios";

// api nest
let baseUrl = 'http://localhost:3000/api';
const successCodes = ['200', '201', '202', '203', '204'];

const createdApi = () => {
  const api = axios.create({
    baseURL: baseUrl,
  })

  api.interceptors.request.use((config) => {
    const token = localStorage.getItem("token")
    if (token) {
      config.headers.Authorization = `Bearer ${token}`
    }
    return config
  })

  return api
}

export const useApi = () => {
  var apiInstance = createdApi();
  return {
    get: (url: string, params?: any) => apiInstance.get(url, { params }).then((res) => {
      console.log('apiInstance',res);
      return handleAllResponse(res, undefined, true)
    }),
    post: (url: string, data: any, message?: string) => apiInstance.post(url, data).then((res) => {
      return handleAllResponse(res, message);
    }),
    put: (url: string, data: any, message?: string) => apiInstance.put(url, data).then((res) => {
      return handleAllResponse(res, message);
    }),
    patch: (url: string, data: any, message?: string) => apiInstance.patch(url, data).then((res) => {
      return handleAllResponse(res, message);
    }),
    delete: (url: string, message?: string) => apiInstance.delete(url).then((res) => handleAllResponse(res, message)),
    postNoMessage: (url: string, data: any) => apiInstance.post(url, data).then((res) => res.data),
    putNoMessage: (url: string, data: any) => apiInstance.put(url, data).then((res) => res.data),
    patchNoMessage: (url: string, data: any) => apiInstance.patch(url, data).then((res) => res.data),
    deleteNoMessage: (url: string) => apiInstance.delete(url).then((res) => res.data),
  };
}

const handleAllResponse = (response: any, message?: string, skipMessage?: boolean) => {
  const responseMessage = response.data?.message || 'Success';
  // const toaster = useToaster()
  const successMessage = message || adjustSuccessMessage(responseMessage) || 'Success';
  if (!skipMessage) {
    if (successCodes.includes(response.data.rc)) {
      // toaster.success(successMessage);
    }
  }
  return response.data;
};

const adjustSuccessMessage = (message: string) => {
  switch (message) {
    case 'Successfully':
    case 'Successfully Create':
    case 'Successfully Update':
    case 'Successfully Delete':
      return 'Sukses';
    default:
      return message;
  }
};
export default async function HttpClient(fetchURL, fetchOptions) {
  return fetch(fetchURL, {
    ...fetchOptions,
    headers: {
      ...fetchOptions.headers,
      "Content-Type": "application/json",
    },
    body: fetchOptions.body ? JSON.stringify(fetchOptions.body) : null,
  }).then(async (respostaDoServer) => {
    return {
      ok: respostaDoServer.ok,
      body: await respostaDoServer.json(),
    };
  });
}

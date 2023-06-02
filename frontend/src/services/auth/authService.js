import HttpClient from "../../infra/HttpClient/HttpClient";
import { tokenService } from "./tokenService";

export const authService = {
  async login({ username, password }) {
    return HttpClient(`${process.env.NEXT_PUBLIC_BACKEND_URL}/api/login`, {
      method: "POST",

      body: {
        username,
        password,
      },
    })
      .then(async (resposta) => {
        console.log(resposta);
        if (!resposta.ok) {
          throw new Error("Usuário e/ou senha inválidos");
        }
        const body = resposta.body;
        tokenService.save(body.data.access_token);
        console.log(body);

        return body;
      })
      .then(async ({ data }) => {
        const { refresh_token } = data;

        const response = await HttpClient("/api/refresh", {
          method: "POST",
          body: {
            refresh_token,
          },
        });

        console.log(response);
        console.log(refresh_token);
      });
  },

  async getSession(ctx = null) {
    const token = tokenService.get(ctx);

    return HttpClient(`${process.env.NEXT_PUBLIC_BACKEND_URL}/api/session`, {
      method: "GET",
      headers: {
        Authorization: `Bearer ${token}`,
      },
    }).then(async (resposta) => {
      if (!resposta.ok) throw new Error("Unauthorized");
      return resposta.body.data;
    });
  },
};

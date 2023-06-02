import HttpClient from "../../src/infra/HttpClient/HttpClient";
import nookies from "nookies";
import { tokenService } from "../../src/services/auth/tokenService";

const REFRESH_TOKEN_NAME = "REFRESH_TOKEN_NAME";

const controllers = {
  storeRefreshToken(req, res) {
    console.log(req.body);
    const ctx = { req, res };
    nookies.set(ctx, REFRESH_TOKEN_NAME, req.body.refresh_token, {
      httpOnly: true,
      sameSite: "lax",
    });

    res.json({
      data: {
        message: "Refresh token armazenado com sucesso!",
      },
    });
  },

  async displayCookies(req, res) {
    const ctx = { req, res };
    res.json({
      data: {
        cookies: nookies.get(ctx),
      },
    });
  },

  async regenerateTokens(req, res) {
    const ctx = { req, res };
    const cookies = nookies.get(ctx);
    const refresh_token = cookies[REFRESH_TOKEN_NAME];

    const refreshResponse = await HttpClient(
      `${process.env.NEXT_PUBLIC_BACKEND_URL}/api/refresh`,
      {
        method: "POST",
        body: {
          refresh_token,
        },
      }
    );

    if (refreshResponse.ok) {
      nookies.set(
        ctx,
        REFRESH_TOKEN_NAME,
        refreshResponse.body.data.refresh_token,
        {
          httpOnly: true,
          sameSite: "lax",
        }
      );
      console.log(refreshResponse.body.data.refresh_token);
      tokenService.save(refreshResponse.body.data.access_token, ctx);

      res.json({
        refreshResponse,
      });
    } else {
      res.json({
        status: 401,
        message: "Unauthorized",
      });
    }
  },
};

const controllerBy = {
  POST: controllers.storeRefreshToken,
  GET: controllers.regenerateTokens,
  // GET: controllers.displayCookies,
};

export default function handler(request, response) {
  if (controllerBy[request.method])
    return controllerBy[request.method](request, response);

  response.status(404).json({
    status: 404,
    message: "Not found",
  });
}

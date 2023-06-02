import nookies from "nookies";
const ACCESS_TOKEN_KEY = "ACCESS_TOKEN_KEY";

const ONE_YEAR = 60 * 60 * 24 * 365;
export const tokenService = {
  save(accessToken, ctx = null) {
    globalThis?.localStorage?.setItem(ACCESS_TOKEN_KEY, accessToken);
    nookies.set(ctx, ACCESS_TOKEN_KEY, accessToken, {
      path: "/",
      maxAge: ONE_YEAR,
      sameSite: "lax",
    });
  },

  get(ctx = null) {
    const cookies = nookies.get(ctx);
    return cookies[ACCESS_TOKEN_KEY];
  },

  delete() {
    globalThis?.localStorage?.removeItem(ACCESS_TOKEN_KEY);
  },
};

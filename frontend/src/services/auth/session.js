import { useRouter } from "next/router";
import { authService } from "./authService";
import React from "react";

export function withSession(funcao) {
  return async (ctx) => {
    try {
      const session = await authService.getSession(ctx);
      const modifiedCtx = {
        ...ctx,
        req: {
          ...ctx.req,
          session,
        },
      };
      return funcao(modifiedCtx);
    } catch (err) {
      return {
        redirect: {
          destination: "/?error=Unauthorized",
          permanent: false,
        },
      };
    }
  };
}

export function useSession() {
  const [session, setSession] = React.useState(null);
  const [loading, setLoading] = React.useState(true);
  const [error, setError] = React.useState(null);

  React.useEffect(() => {
    // só executa uma vez
    authService
      .getSession()
      .then((userSession) => {
        console.log(userSession);
        setSession(userSession);
      })
      .catch((error) => {
        console.error(error);
        setError(error);
      })
      .finally(() => {
        setLoading(false);
      });
  }, []);

  return {
    data: { session },
    error,
    loading,
  };
}

export function withSessionHOC(Component) {
  return function Wrapper(props) {
    const session = useSession();
    const router = useRouter();
    if (!session.loading && session.error) {
      console.log("redireciona o usuário para home");
      router.push("/?error=401");
    }
    const modifiedProps = {
      ...props,
      session: session.data.session,
    };
    return <Component {...modifiedProps} />;
  };
}

package tech.blur.features.auth.api;

import retrofit2.Call;
import retrofit2.http.Body;
import retrofit2.http.POST;
import tech.blur.core.model.UserToken;
import tech.blur.core.network.Wrapper;
import tech.blur.core.model.User;
import tech.blur.core.model.UserAuth;

public interface AuthApi {
    @POST("users/auth")
    Call<Wrapper<UserToken>> CheckUser(@Body UserAuth userAuth);

}

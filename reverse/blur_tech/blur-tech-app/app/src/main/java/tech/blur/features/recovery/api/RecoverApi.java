package tech.blur.features.recovery.api;

import retrofit2.Call;
import retrofit2.http.Body;
import retrofit2.http.Header;
import retrofit2.http.POST;
import retrofit2.http.Path;
import tech.blur.core.network.Wrapper;
import tech.blur.core.model.RecoveryKey;
import tech.blur.core.model.User;

public interface RecoverApi {

    @POST ("/users/recover/{id}")
    Call<Wrapper<User>> recoverUser(@Body RecoveryKey key,
                                    @Path("id") String id,
                                    @Header("token") String token);

}

package tech.blur.features.objective.api;

import retrofit2.Call;
import retrofit2.http.GET;
import retrofit2.http.Header;
import tech.blur.core.network.Wrapper;
import tech.blur.core.model.Objective;

public interface ObjectiveApi {

    @GET("objective")
    Call<Wrapper<Objective>> getObjective(@Header("token") String token);

}

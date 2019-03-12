package tech.blur.ctfbackend.api;

import com.fasterxml.jackson.databind.ser.Serializers;
import org.springframework.beans.factory.annotation.Autowired;
import org.springframework.web.bind.annotation.GetMapping;
import org.springframework.web.bind.annotation.RequestHeader;
import org.springframework.web.bind.annotation.ResponseBody;
import org.springframework.web.bind.annotation.RestController;
import tech.blur.ctfbackend.models.Objective;
import tech.blur.ctfbackend.services.ObjectiveService;

@RestController
public class ObjectiveController {

    private static final String OBJECTIVE_PATH = Resources.API_PREFIX + "objective";

    @Autowired
    private ObjectiveService service;

    @GetMapping(OBJECTIVE_PATH)
    public @ResponseBody
    BaseResponse<Objective> getObjective(@RequestHeader("token") String token){
        BaseResponse<Objective> response = new BaseResponse<>();

        if (!token.equals(Resources.TOKEN)){
            response.setStatus("INVALID TOKEN");
            response.setMessage("Invalid token!");
        } else {

            Objective objective = service.getObjective();

            if (null == objective) {
                response.setStatus("OBJECTIVE_NOT_EXIST");
                response.setMessage("Objective not found!");
            } else {
                response.setData(objective);
            }
        }
        return response;
    }

}

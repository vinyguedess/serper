import { GoogleService } from "../Services/GoogleService";

export const SERPFactory = service => 
{
    if (service === "google") return new GoogleService();

    return null;
};

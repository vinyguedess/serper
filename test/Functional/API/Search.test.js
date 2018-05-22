import { expect } from "chai";
import Axios from "axios";
import { app } from "./../../../src/bootstrap";

describe("Test/Functional/API/SearchTest", function() 
{
    before(() => (this.app = app.listen(3000)));

    it("Should search for results on Google by term", done => 
    {
        Axios({
            baseURL: "http://localhost:3000",
            url: "/api/search/google?term=aluguel de carros"
        })
            .then(httpResponse => 
            {
                expect(httpResponse.status).to.be.equal(200);
                expect(httpResponse.data).to.be.an("array");
            })
            .finally(done);
    });

    after(() => this.app.close());
});

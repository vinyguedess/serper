import { expect } from "chai";
import { SERPFactory } from "./../../../../src/API/Search/Factory/SERPFactory";

describe("Test/Unit/API/Search/GoogleSearchTest", () => 
{
    const factory = SERPFactory("google");

    it("Should get a list of results from Google", done => 
    {
        factory
            .search("SERP")
            .then(results => 
            {
                expect(results).to.be.an("array");
                expect(results.length).to.be.at.least(90);

                let [result] = results;
                expect(result.title).to.be.a("string");
                expect(result.description).to.be.a("string");
                expect(result.url).to.be.a("string");
                expect(result.position).to.be.a("object");
            })
            .finally(done);
    });
});

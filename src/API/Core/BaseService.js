export class BaseService 
{
    constructor() 
    {
        this.errors = {};
    }

    addError(type, message) 
    {
        if (!this.errors[type]) this.errors[type] = [];

        this.errors[type].push(message);
    }

    getErrors() 
    {
        return this.errors;
    }
}

export interface ApiResponse {
    code: number,
    data: any,
    message: string
}

export interface ConferenceData {
    action:string,
    year: number,
    startDate: string,
    endDate: string,
    venue: string,
    theme: string,
    aboutConference: string,
    defaultFee: number,
    foreignerFee:number,
    guestFee: number,
}
// export interface UserDataArray extends Array<User> {}

# Time Tracker Architecture

Based on the [Product Specifications](./specifications.md), we can know basic requirements of the app will look like this:

**INPUT**
1. The time users check in
2. The time users check out
3. Users today Topic
4. Users today notes
5. User UID

**OUTPUT**
Same like above

## User flow

1. Users open the app
2. Users Input their UID (system fecth userprofile)
3. Users open dashboard (system show timetrack dashboard)
4. Users start time tracking (System start tracking locally)
5. Users stop the time tracker (Stop tracking and save input)
6. Users write todays subject and notes (System store the notes)
7. Users finised tracking (System upload the data to the database tracking)
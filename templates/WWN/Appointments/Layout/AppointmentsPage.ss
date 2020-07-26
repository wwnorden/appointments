<section class="wrapper">
    <div class="inner">
        <%-- Breadcrumbs --%>
        <% include BreadCrumbs %>
        <hr>

        <h1>$Headline.RAW</h1>
        <br>
        <% if $Lead %><p>$Lead.RAW</p><% end_if %>
        <% if $Content %>
            $Content
        <% end_if %>

        <% if $Appointments %>
            <table class="table table-striped">
                <tbody>
                    <% loop $Appointments %>
                        <tr>
                            <td>$Date.Format('cccc, dd.MM.y')</td>
                            <td>$Date.Format('H:mm')</td>
                            <td>$Unity</td>
                            <td>$Subject</td>
                            <td>$Location</td>
                            <td>$Leadership</td>
                            <td>$Clothing</td>
                        </tr>
                    <% end_loop %>
                </tbody>
            </table>
        <% end_if %>
    </div>
</section>





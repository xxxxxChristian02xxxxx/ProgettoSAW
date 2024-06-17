const table = document.querySelector('#edituserTable tbody')

document.addEventListener('DOMContentLoaded', function () {
    // Si ottengono i dati
    getData(1, 5);
});

function getData(currentPage, rowsPerPage) {
    fetch('../backend/be_editusers.php')
        .then(response => response.json())
        .then(data => {
            populateTable(data, currentPage, rowsPerPage, table);
            updatePagination(data, currentPage, rowsPerPage, table);

            populateColumnSelection(data, table);

            var input = document.getElementById("editUserSearch");
            input.addEventListener("input", function () {
                if (this.value === "") {
                    populateTable(data, currentPage, rowsPerPage, table);
                } else {
                    searchTable(data, input, currentPage, rowsPerPage, table);
                }
            });
        })
        .catch(error => console.error('Error in reaching data:', error));
}

function popup(cell, row, dataTarget) {
    const popUp = document.getElementById('popUp');
    const popUpContent = document.getElementById('popUpContent');
    if (popUp && popUpContent) {
        popUp.classList.remove('hidden');
        document.body.style.overflow = 'hidden';
        switch (cell) {
            case row.cells[4]:
                appendPromoteDemoteToContainer(popUpContent, dataTarget)
                break;
            case row.cells[5]:
                appendBanUnabanToContainer(popUpContent, dataTarget)
                break;
            case row.cells[6]:
                appendModifyToContainer(popUpContent, cell)
                break;
            case row.cells[7]:
                appendDeleteToContainer(popUpContent, dataTarget);
        }
        const closePopUpButton = document.getElementById('closePopUpButton');
        switch (cell) {
            case row.cells[4]:
                const yesPromoteDemote = document.getElementById("yesPromoteDemote");
                const noPromoteDemote = document.getElementById("noPromoteDemote");

                yesPromoteDemote.addEventListener('click', () => {
                    promoteDemoteFetch(dataTarget, cell);
                    popUp.classList.add('hidden');
                    document.body.style.overflow = 'auto';
                });

                noPromoteDemote.addEventListener('click', () => {
                    popUp.classList.add('hidden');
                    document.body.style.overflow = 'auto';
                });
                break;
            case row.cells[5]:
                const yesBanUnban = document.getElementById("yesBanUnban");
                const noBanUnban = document.getElementById("noBanUnban");

                yesBanUnban.addEventListener('click', () => {
                    banUnbanFetch(dataTarget, cell);
                    popUp.classList.add('hidden');
                    document.body.style.overflow = 'auto';
                });

                noBanUnban.addEventListener('click', () => {
                    popUp.classList.add('hidden');
                    document.body.style.overflow = 'auto';
                });
                break;
            case row.cells[6]:
                const modifyAmount = document.getElementById("modifymount");
                const changeMoney = document.getElementById("changeMoney");
                const space = document.getElementById("alertspace");
                const resetMoney = document.getElementById("resetAmount")
                var isnum = null;
                var num;

                var confirm = document.getElementById('confirm');
                modifyAmount.addEventListener("input", () => {
                    num = modifyAmount.value;

                    const regex = /^\d+$/;
                    if (regex.test(num)) {
                        isnum = true;
                    } else {
                        isnum = false;
                        if (num.includes(" ")) {
                            space.classList.remove('hidden');
                            space.style.color = "red";
                        } else {
                            space.classList.add('hidden');
                        }
                    }
                })
                changeMoney.addEventListener("click", () => {
                    if (isnum) {
                        confirm.classList.remove('hidden');
                        const yesChange = document.getElementById('yesChange');
                        const noChange = document.getElementById('noChange');

                        yesChange.addEventListener('click', () => {
                            dataTarget['operation'] = 1;
                            dataTarget['money'] = num;
                            modifyFetch(dataTarget, cell);
                            popUp.classList.add('hidden');
                            document.body.style.overflow = 'auto';
                        });

                        noChange.addEventListener('click', () => {
                            popUp.classList.add('hidden');
                            document.body.style.overflow = 'auto';
                        });
                    } else {
                        alert("not valied amount");

                    }
                })
                resetMoney.addEventListener("click", (event) => {
                    confirm.classList.remove('hidden');
                    const yesReset = document.getElementById('yesChange');
                    const noReset = document.getElementById('noChange');

                    yesReset.addEventListener('click', () => {
                        dataTarget['operation'] = 2;
                        modifyFetch(dataTarget, cell);
                        popUp.classList.add('hidden');
                        document.body.style.overflow = 'auto';
                    });

                    noReset.addEventListener('click', () => {
                        popUp.classList.add('hidden');
                        document.body.style.overflow = 'auto';
                    });
                });
                break;
            case row.cells[7]:
                const yesDelete = document.getElementById("yesDelete");
                const noDelete = document.getElementById("noDelete");

                yesDelete.addEventListener('click', () => {
                    deleteUserFetch(dataTarget, cell);
                    row.remove();
                    popUp.classList.add('hidden');
                    document.body.style.overflow = 'auto';
                });

                noDelete.addEventListener('click', () => {
                    popUp.classList.add('hidden');
                    document.body.style.overflow = 'auto';
                });
                break;
        }

        closePopUpButton.addEventListener('click', () => {
            popUp.classList.add('hidden');
            document.body.style.overflow = 'auto';
        });

        popUp.addEventListener('click', (event) => {
            if (event.target === popUp) {
            } else if (event.target.closest('#modalContent') === null) {
                popUp.classList.add('hidden');
                document.body.style.overflow = 'auto';
            }
        });

        popUpContent.addEventListener('click', (event) => {
            event.stopPropagation();
        });
    }
}
